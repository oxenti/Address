<?php
namespace Address\Model\Table;

use Address\Model\Entity\Address;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Addresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cities
 */
class AddressesTable extends Table
{

    use SoftDeleteTrait;
    
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

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER',
            'className' => 'Address.Cities'
        ]);
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
        return $rules;
    }
}
