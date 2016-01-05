<?php
namespace Address\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Utility\Inflector;

/**
 * Addressable behavior
 */
class AddressableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * getEntityAddressId method
     * @param TableRegistry $table Model's Table
     * @param int $entityKey Addressable entity's id
     * @param string $entityFK Addressable entity's primary key field name
     * @return int|false
     */
    public function getEntityAddressId($table, $entityKey, $entityFK = 'user_id')
    {
        $address = $table->find()
            ->where([$entityFK => $entityKey])
            ->first();

        return $address ? $address->address_id : false;
    }
}
