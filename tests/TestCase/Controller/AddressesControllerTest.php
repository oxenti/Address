<?php
namespace Address\Test\TestCase\Controller;

use Address\Controller\AddressesController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Address\Controller\AddressesController Test Case
 */
class AddressesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.addresses',
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
            'params' => 'limit=2&page=1&sort=name&finder=list'
        ];
        $caso2 = [
            'type' => 'all',
            'limit' => 4,
            'page' => 2,
            'params' => 'limit=4&page=2&sort=name&finder=all'
        ];
        $caso3 = [];
        $caso4 = [
            'type' => 'all',
            'limit' => 10,
            'page' => 20,
            'params' => 'limit=4&page=20&sort=name&finder=all'
        ];

        return [[$caso1, true], [$caso2, true], [$caso3, true], [$caso4, false]];
    }

    /**
     * additionProvider method
     *
     * @return array
     */
    
    // public function viewProvider()
    // {
    //     $case1 = [

    //     ]

    //     return [[$caso1, true]];
    // }

    /**
     * Test index method
     * @dataProvider additionProvider
     * @return void
     */
    public function testIndex($caso, $responseStatus)
    {
        $this->Addresses = TableRegistry::get('Address.Addresses');
        if (empty($caso)) {
            $addresses = $this->Addresses->find()->contain(['Cities', 'Cities.States', 'Cities.States.Countries']);
            $caso['params'] = '';
            $caso['type'] = '';
        } else {
            $addresses = $this->Addresses
                ->find($caso['type'])
                ->limit($caso['limit'])
                ->page($caso['page'])
                ->contain(['Cities', 'Cities.States', 'Cities.States.Countries'])
                ->toArray();
        }
        
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/address/addresses' . '?' . $caso['params']);
        if ($responseStatus) {
            $response = json_decode($this->_response->body());
            $expected = json_encode($addresses, JSON_PRETTY_PRINT);
            $this->assertResponseOK();
            $this->assertEquals($expected, json_encode($response->addresses, JSON_PRETTY_PRINT));
        } else {
            $this->assertResponseError();
        }
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->Addresses = TableRegistry::get('Address.Addresses');
        $address = $this->Addresses->find()->where(['id' => 1]);
        $this->configRequest([
           'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/address/addresses/1');
        $this->assertResponseOK();
        $expected = json_encode($address, JSON_PRETTY_PRINT);
        $this->assertEquals($expected, $response, 'message');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
