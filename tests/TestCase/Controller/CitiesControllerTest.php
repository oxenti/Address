<?php
namespace Address\Test\TestCase\Controller;

use Address\Controller\CitiesController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Address\Controller\CitiesController Test Case
 */
class CitiesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.cities',
        'plugin.address.states',
        'plugin.address.countries'
    ];

    /**
     * additionProvider method
     *
     * @return array
     */
    
    public function additionProvider()
    {
        $caso1 = [
            'type' => 'list',
            'limit' => 2,
            'page' => 1,
            'order' => 'Cities.name',
            'params' => 'limit=2&page=1&sort=name&finder=list'
        ];
        $caso2 = [
            'type' => 'list',
            'limit' => 4,
            'page' => 2,
            'order' => 'Cities.name',
            'params' => 'limit=4&page=2&sort=name&finder=list'
        ];
        $caso3 = [];
        
        return [[$caso1], [$caso2], [$caso3]];
    }

    /**
     * Test index method
     * @dataProvider additionProvider
     * @return void
     */
    public function testIndex($caso)
    {
        $this->Cities = TableRegistry::get('Address.Cities');
        if (empty($caso)) {
            $cities = $this->Cities->find()->order('Cities.name')->contain(['States', 'States.Countries']);
            $caso['params'] = '';
            $caso['type'] = '';
        } else {
            $cities = $this->Cities
                ->find($caso['type'])
                ->limit($caso['limit'])
                ->page($caso['page'])
                ->order($caso['order'])
                ->contain(['States'])
                ->toArray();
        }
        $expected = json_encode($cities);
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/address/cities/index/' . '?' . $caso['params']);
        $response = json_decode($this->_response->body());
        $this->assertResponseOK();
        $this->assertEquals($expected, json_encode($response->cities));
    }
}
