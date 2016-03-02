<?php
namespace Address\Model\Table;

use Address\Model\Entity\Address;
use Address\Model\Table\AppTable;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

// use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Addresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cities
 */
class AddressesTable extends AppTable
{

    // use SoftDeleteTrait;
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('addresses');
        $this->displayField('street');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Address.Geocodable');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER',
            'className' => 'Address.Cities'
        ]);

        $this->_setAppRelations(Configure::read('address_plugin.relations'));
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('street', 'maxLength', ['rule' => ['maxLength', 45]])
            ->requirePresence('street', 'create')
            ->notEmpty('street');

        $validator
            ->add('neighborhood', 'maxLength', ['rule' => ['maxLength', 50]])
            ->requirePresence('neighborhood', 'create')
            ->notEmpty('neighborhood');

        $validator
            ->add('is_active', 'valid', ['rule' => 'boolean'])
            ->notEmpty('is_active');

        $validator
            ->add('city_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('city_id', 'create')
            ->notEmpty('city_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        return $this->_setExtraBuildRules($rules, Configure::read('address_plugin.rules'));
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->manually_updated) {
            $address = $this->parseGeocodedAddress($this->decodeAddress($entity->lat, $entity->lng));

            foreach ($address as $key => $value) {
                $entity->$key = $value;
            }
            $entity->formatted_address = $this->formattedAddress($entity);
            $entity->manually_updated = false;

        } else {
            $formattedAddress = $this->formattedAddress($entity);
            $coordinates = $this->getCoordinates($formattedAddress);

            if (! $coordinates) {
                $coordinates = $this->getCoordinates($this->formattedNeighborhood($entity));
            }
           
            if (! $coordinates) {
                return false;
            }
            
            $entity->lat = $coordinates[0];
            $entity->lng = $coordinates[1];
            $entity->formatted_address = $formattedAddress;
        }
    }

    protected function formattedAddress($entity)
    {
        $city = $this->Cities->get($entity->city_id, ['contain' => 'States']);
        $address = '';
        if ($entity->street) {
            $address .= $entity->street;
        }

        if ($entity->complement) {
            $address .= ', ' . $entity->complement;
        }

        if ($entity->neighborhood) {
            $address .= ' - ' . $entity->neighborhood;
        }

        if (isset($city->name)) {
            $address .= ', ' . $city->name . ', ' . $city->state->uf;
        }
        
        return $address;
    }

    protected function formattedNeighborhood($entity)
    {
        $city = $this->Cities->get($entity->city_id);
        $address = '';
        if ($entity->neighborhood) {
            $address .= $entity->neighborhood;
        }
        if ($city->name) {
            $address .= ($address == '') ? $city->name . ', ' . $city->state->uf : ', ' . $city->name . ', ' . $city->state->uf;
        }
        
        return $address;
    }

    protected function parseGeocodedAddress($address) {
        if (isset($address['city'])) {
            $city = $this->Cities->findByName($address['city'])
                ->first();
            $address['city_id'] = $city->id;
            unset($address['city']);
        }
        
        return $address;
    }

    /**
     * beforeSave method
     */
    // public function beforeSave($event, $entity, $options)
    // {
    //     debug($entity);
    //     debug($event);
    //     die();
    //     if (! $entity->isNew()) {
            
    //     }
    // }
}
