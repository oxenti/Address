<?php
namespace Address\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesFixture
 *
 */
class CountriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'sigla' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'name' => 'Brasil',
            'sigla' => 'BR'
        ],
        [
            'id' => 2,
            'name' => 'Estados Unidos da América',
            'sigla' => 'EUA'
        ],
        [
            'id' => 3,
            'name' => 'Argentina',
            'sigla' => 'ARG'
        ],
        [
            'id' => 4,
            'name' => 'Chile',
            'sigla' => 'CHI'
        ],
        [
            'id' => 5,
            'name' => 'Canadá',
            'sigla' => 'CAN'
        ],
        [
            'id' => 6,
            'name' => 'México',
            'sigla' => 'MEX'
        ],
    ];
}
