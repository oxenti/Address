<?php
namespace Address\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity.
 *
 * @property int $id
 * @property int $city_id
 * @property \Address\Model\Entity\City $city
 * @property string $street
 * @property string $neighborhood
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $is_active
 */
class Address extends Entity
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

    protected $_hidden = ['created', 'is_active', 'modified'];
}
