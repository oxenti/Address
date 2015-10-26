<?php
namespace Address\Model\Entity;

use Cake\ORM\Entity;

/**
 * State Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $uf
 * @property int $country_id
 * @property \Address\Model\Entity\Country $country
 * @property \Address\Model\Entity\City[] $cities
 */
class State extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
