<?php
namespace Address\Model\Table;

use Address\Model\Entity\Country;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Countries Model
 *
 * @property \Cake\ORM\Association\HasMany $States
 */
class CountriesTable extends Table
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

        $this->table('countries');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('States', [
            'foreignKey' => 'country_id',
            'className' => 'Address.States'
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
            ->add('name', 'maxLength', ['rule' => ['maxLength', 60]])
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->add('sigla', 'maxLength', ['rule' => ['maxLength', 10]])
            ->requirePresence('sigla', 'create')
            ->notEmpty('sigla');

        return $validator;
    }
}
