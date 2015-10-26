<?php
namespace Address\Test\TestCase\Controller;

use Address\Controller\CountriesController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Address\Controller\CountriesController Test Case
 */
class CountriesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
            'limit' => 2,
            'page' => 1,
            'order' => 'name',
            'params' => 'limit=2&page=1&sort=name'
        ];
        $caso2 = [
            'limit' => 4,
            'page' => 2,
            'order' => 'name',
            'params' => 'limit=4&page=2&sort=name'
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
        $this->Countries = TableRegistry::get('Address.countries');
        if (empty($caso)) {
            $countries = $this->Countries->find('list');
            $caso['params'] = '';
        } else {
            $countries = $this->Countries
                ->find('list')
                ->limit($caso['limit'])
                ->page($caso['page'])
                ->order($caso['order'])
                ->toArray();
        }
        $expected = json_encode($countries);
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/address/countries?' . $caso['params']);
        $response = json_decode($this->_response->body());
        $this->assertResponseOK();
        $this->assertEquals($expected, json_encode($response->countries));
    }
}
