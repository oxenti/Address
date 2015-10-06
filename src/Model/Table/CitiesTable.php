<?php
namespace Address\Model\Table;

use Address\Model\Entity\City;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $States
 * @property \Cake\ORM\Association\HasMany $Addresses
 */
class CitiesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('cities');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
            'className' => 'Address.States'
        ]);
        $this->hasMany('Addresses', [
            'foreignKey' => 'city_id',
            'className' => 'Address.Addresses'
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
            ->add('name', 'maxLength', ['rule' => ['maxLength', 50]])
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->add('uf', 'maxLength', ['rule' => ['maxLength', 4]])
            ->requirePresence('uf', 'create')
            ->notEmpty('uf');
        $validator
            ->requirePresence('state_id', 'create')
            ->add('state_id', 'valid', ['rule' => 'numeric'])
            ->notEmpty('state_id');

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
        $rules->add($rules->existsIn(['state_id'], 'States'));
        return $rules;
    }
}
