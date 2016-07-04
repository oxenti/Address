<?php
namespace Address\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

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


    protected $_hidden = ['created', 'is_active', 'modified', '_joinData'];
    protected $_virtual = ['full_address'];

    /**
     * virtual field full name
     */
    protected function _getFullAddress()
    {
        $address = '';

        if (isset($this->_properties['street'])) {
            $address .= $this->_properties['street'];
        }
        if (isset($this->_properties['complement'])) {
            $address .= ', ' . $this->_properties['complement'];
        }
        if (isset($this->_properties['neighborhood'])) {
            $address .= ', ' . $this->_properties['neighborhood'];
        }
        if (isset($this->_properties['city'])) {
            if (! isset($this->_properties['city']->name) && isset($this->_properties['city_id'])) {
                $Cities = TableRegistry::get('Cities');
                $city = $Cities->get($this->_properties['city_id'], ['contain' => ['Cities', 'Cities.States', 'Cities.States.Countries']]);
                $this->_properties['city'] = $city;
            }
            $address .= ', ' . $this->_properties['city']->name;
        }
        if (isset($this->_properties['city']->state->uf)) {
            $address .= '-' . $this->_properties['city']->state->uf;
        }
        if (isset($this->_properties['city']->state->country->name)) {
            $address .= ', ' . $this->_properties['city']->state->country->name;
        }
        if (isset($this->_properties['zipcode'])) {
            $address .= ($this->_properties['zipcode']) ? (', CEP:' . $this->_properties['zipcode']) : '';
        }

        return $address;
    }
}
