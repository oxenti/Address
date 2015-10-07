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
     * additionProvider method
     *
     * @return array
     */
    
    public function viewProvider()
    {
        $case1 = 1;
        $case2 = 44;

        return [[$case1, true], [$case2, false]];
    }

    /**
     * Test view method
     * @dataProvider viewProvider
     * @return void
     */
    public function testView($id, $responseStatus)
    {
        $this->Addresses = TableRegistry::get('Address.Addresses');
        
        $address = $this->Addresses
            ->find()
            ->contain([
                'Cities',
                'Cities.States',
                'Cities.States.Countries'
            ])
            ->where(['Addresses.id' => $id])
            ->first();

        $this->configRequest([
           'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/address/addresses/' . $id);
        if ($responseStatus) {
            $this->assertResponseOK();
            $response = $this->_response->body();
            $expected = json_encode(['address' => $address], JSON_PRETTY_PRINT);
            $this->assertEquals($expected, $response, 'message');
        } else {
            $this->assertResponseError();
        }
    }

    /**
     * additionProvider method
     *
     * @return array
     */
    
    public function addProvider()
    {
        $case1 = [
            'city_id' => 8,
            'street' => 'test insert 1',
            'neighborhood' => 'testeando',
        ];
        $case2 = [
            'city_id' => 45,
            'street' => 'test insert 2',
            'neighborhood' => 'Lorem ipsum dolor sit amet',
        ];

        return [[$case1, true], [$case2, false]];
    }

    /**
     * Test add method
     * @dataProvider addProvider
     * @return void
     */
    public function testAdd($data, $responseStatus)
    {
        $this->Addresses = TableRegistry::get('Address.Addresses');
        $countInitial = $this->Addresses->find()->count();
        $this->configRequest([
           'headers' => ['Accept' => 'application/json']
        ]);
        $this->post('/address/addresses', $data);
        $countEnd = $this->Addresses->find()->count();
        if ($responseStatus) {
            $this->assertResponseOK();
            $expected = $countInitial + 1;
            $response = json_decode($this->_response->body());
            $record = $this->Addresses->get($response->id);
            $this->assertEquals($data['city_id'], $record->city_id, 'message');
            $this->assertEquals($data['street'], $record->street, 'message');
            $this->assertEquals($data['neighborhood'], $record->neighborhood, 'neighborhood');
        } else {
            $this->assertResponseError();
            $expected = $countInitial;
        }
        $this->assertEquals($expected, $countEnd, 'message');
    }

    /**
     * Test edit method
     * @dataProvider addProvider
     * @return void
     */
    public function testEdit($data, $responseStatus)
    {
        $id = 1;
        $this->Addresses = TableRegistry::get('Address.Addresses');
        $countInitial = $this->Addresses->find()->count();
        $this->configRequest([
           'headers' => ['Accept' => 'application/json']
        ]);
        $this->put('/address/addresses/' . $id, $data);
        $countEnd = $this->Addresses->find()->count();
        $expected = $countInitial;
        if ($responseStatus) {
            $this->assertResponseOK();
            $response = json_decode($this->_response->body());
            $this->assertEquals($id, $response->id, 'message');
            $record = $this->Addresses->get($response->id);
            $this->assertEquals($data['city_id'], $record->city_id, 'message');
            $this->assertEquals($data['street'], $record->street, 'message');
            $this->assertEquals($data['neighborhood'], $record->neighborhood, 'neighborhood');
        } else {
            $this->assertResponseError();
        }
        $this->assertEquals($expected, $countEnd, 'message');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $id = 1;
        $this->Addresses = TableRegistry::get('Address.Addresses');
        $countInitial = $this->Addresses->find()->count();
        $this->configRequest([
           'headers' => ['Accept' => 'application/json']
        ]);
        $result = $this->delete('/adress/addresses/' . $id);
        // Check that the response was a 200
        $this->assertResponseOk();
        $student = $students->find('all', ['withDeleted'])
           ->where(['Students.id' => 1]);
           ->first();
        $this->assertNotEmpty($student, 'message');
        $this->assertEquals(false, $student->is_active);
    }
}
