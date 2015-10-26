<?php
namespace Address\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatesFixture
 *
 */
class StatesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 75, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'uf' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'country_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_states_countries1_idx' => ['type' => 'index', 'columns' => ['country_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_states_countries1' => ['type' => 'foreign', 'columns' => ['country_id'], 'references' => ['countries', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'name' => 'Bahia',
            'uf' => 'BA',
            'country_id' => 1
        ],
        [
            'id' => 2,
            'name' => 'Ceará',
            'uf' => 'CE',
            'country_id' => 1
        ],
        [
            'id' => 3,
            'name' => 'Alagoas',
            'uf' => 'AL',
            'country_id' => 1
        ],
        [
            'id' => 4,
            'name' => 'Pernambuco',
            'uf' => 'PE',
            'country_id' => 1
        ],
        [
            'id' => 5,
            'name' => 'São Paulo',
            'uf' => 'SP',
            'country_id' => 1
        ],
        [
            'id' => 6,
            'name' => 'Rio de Janeiro',
            'uf' => 'RJ',
            'country_id' => 1
        ],
        [
            'id' => 7,
            'name' => 'Rio Grande do Sul',
            'uf' => 'RS',
            'country_id' => 1
        ],
        [
            'id' => 8,
            'name' => 'Minas Gerais',
            'uf' => 'MG',
            'country_id' => 1
        ],
        [
            'id' => 9,
            'name' => 'Amazonas',
            'uf' => 'AM',
            'country_id' => 1
        ],
        [
            'id' => 10,
            'name' => 'Sergipe',
            'uf' => 'SE',
            'country_id' => 1
        ],
        [
            'id' => 11,
            'name' => 'Tocantins',
            'uf' => 'TO',
            'country_id' => 1
        ],
        [
            'id' => 12,
            'name' => 'Maranhão',
            'uf' => 'MA',
            'country_id' => 1
        ],
    ];
}
