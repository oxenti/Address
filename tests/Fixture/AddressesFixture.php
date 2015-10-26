<?php
namespace Address\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AddressesFixture
 *
 */
class AddressesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'city_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'street' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'neighborhood' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'is_active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_addresses_cities1_idx' => ['type' => 'index', 'columns' => ['city_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_addresses_cities1' => ['type' => 'foreign', 'columns' => ['city_id'], 'references' => ['cities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'city_id' => 1,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
        [
            'id' => 2,
            'city_id' => 2,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
        [
            'id' => 3,
            'city_id' => 3,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
        [
            'id' => 4,
            'city_id' => 4,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
        [
            'id' => 5,
            'city_id' => 5,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
        [
            'id' => 6,
            'city_id' => 6,
            'street' => 'Lorem ipsum dolor sit amet',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-09-29 18:42:11',
            'modified' => '2015-09-29 18:42:11',
            'is_active' => 1
        ],
    ];
}
