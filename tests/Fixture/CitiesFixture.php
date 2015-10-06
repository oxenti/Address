<?php
namespace Address\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CitiesFixture
 *
 */
class CitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'state_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'uf' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'fk_cities_states1_idx' => ['type' => 'index', 'columns' => ['state_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_cities_states1' => ['type' => 'foreign', 'columns' => ['state_id'], 'references' => ['states', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'state_id' => 1,
            'name' => 'Salvador',
            'uf' => 'SSA'
        ],
        [
            'id' => 2,
            'state_id' => 4,
            'name' => 'Barra do Mendes',
            'uf' => 'BM'
        ],
        [
            'id' => 3,
            'state_id' => 1,
            'name' => 'Jacobina',
            'uf' => 'JA'
        ],
        [
            'id' => 4,
            'state_id' => 1,
            'name' => 'Vitoria da Conquista',
            'uf' => 'VC'
        ],
        [
            'id' => 5,
            'state_id' => 1,
            'name' => 'Guanambi',
            'uf' => 'Gua'
        ],
        [
            'id' => 6,
            'state_id' => 1,
            'name' => 'São Paulo',
            'uf' => 'SP'
        ],
        [
            'id' => 7,
            'state_id' => 5,
            'name' => 'Santos',
            'uf' => 'SA'
        ],
        [
            'id' => 8,
            'state_id' => 5,
            'name' => 'Campinas',
            'uf' => 'CA'
        ],
        [
            'id' => 9,
            'state_id' => 6,
            'name' => 'Rio de Janeiro',
            'uf' => 'RJ'
        ],
        [
            'id' => 10,
            'state_id' => 6,
            'name' => 'Niteroi',
            'uf' => 'NI'
        ],
        [
            'id' => 11,
            'state_id' => 6,
            'name' => 'São Sebastião',
            'uf' => 'SS'
        ],
        [
            'id' => 12,
            'state_id' => 7,
            'name' => 'Porto Alegre',
            'uf' => 'PA'
        ],
        [
            'id' => 13,
            'state_id' => 7,
            'name' => 'Brumado',
            'uf' => 'BR'
        ],
        [
            'id' => 14,
            'state_id' => 10,
            'name' => 'Sergipe',
            'uf' => 'Se'
        ],
        [
            'id' => 15,
            'state_id' => 10,
            'name' => 'Aracajú',
            'uf' => 'Ar'
        ],
        [
            'id' => 16,
            'state_id' => 11,
            'name' => 'Manaus',
            'uf' => 'Am'
        ],
        [
            'id' => 17,
            'state_id' => 12,
            'name' => 'Recife',
            'uf' => 'RE'
        ]
    ];
}
