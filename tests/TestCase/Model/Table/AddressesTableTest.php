<?php
namespace Address\Test\TestCase\Model\Table;

use Address\Model\Table\AddressesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Address\Model\Table\AddressesTable Test Case
 */
class AddressesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.addresses',
        'plugin.address.cities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Addresses') ? [] : ['className' => 'Address\Model\Table\AddressesTable'];
        $this->Addresses = TableRegistry::get('Addresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Addresses);

        parent::tearDown();
    }

    /**
     * additionProvider method
     *
     * @return array
     */
    
    public function additionProvider()
    {
        $cases = [
            [
                'city_id' => 1,
                'street' => 'Lorem ipsum dolor sit amet',
                'neighborhood' => 'Lorem ipsum dolor sit amet'
            ],
            [
                'id' => '',
                'city_id' => '',
                'street' => '',
                'neighborhood' => ''
            ],
            [
                'id' => 'safff',
                'city_id' => 'asdvds',
                'street' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit ',
                'neighborhood' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolo',
                'is_active' => 'dqwqwf',
            ],
            [
                'city_id' => 44,
                'street' => 'Lorem ipsum dolor sit amet',
                'neighborhood' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        return [[$cases]];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    // public function testInitialize()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test validationDefault method
     * @dataProvider additionProvider
     * @return void
     */
    public function testValidationDefault($cases)
    {
        //caso valido
        $errors = $this->Addresses->validator()->errors($cases[0]);
        $this->assertEmpty($errors, 'Dados validos foram considerados invalidos para Address');

        $errors = $this->Addresses->validator()->errors($cases[1]);
        $this->assertNotEmpty($errors, 'campos vazios n retornou erro');
        $expected = [
            'city_id' => ['_empty' => 'This field cannot be left empty'],
            'street' => ['_empty' => 'This field cannot be left empty'],
            'neighborhood' => ['_empty' => 'This field cannot be left empty']
        ];
        $this->assertEquals($expected, $errors, 'erro não foi o experado para campos vazios');

        $errors = $this->Addresses->validator()->errors($cases[2]);
        $this->assertNotEmpty($errors, 'caso invalido não retornou erro');
        $expected = [
            'id' => ['valid' => 'The provided value is invalid'],
            'street' => ['maxLength' => 'The provided value is invalid'],
            'neighborhood' => ['maxLength' => 'The provided value is invalid'],
            'city_id' => ['valid' => 'The provided value is invalid'],
            'is_active' => ['valid' => 'The provided value is invalid'],
        ];
        $this->assertEquals($expected, $errors, 'erros esperado não corresponde retornado');

        $errors = $this->Addresses->validator()->errors([]);
        $this->assertNotEmpty($errors, 'não foi retornado erro para para array vazio');
        $expected = [
            'street' => ['_required' => 'This field is required'],
            'neighborhood' => ['_required' => 'This field is required'],
            'city_id' => ['_required' => 'This field is required']
        ];
        $this->assertEquals($expected, $errors, 'o erro retornado não foi o esperado para campos inexistentes');
    }
    /**
     * Test buildRules method
     * @dataProvider additionProvider
     * @return void
     */
    public function testBuildRules($cases)
    {
        //caso valido
        $addressValido = $this->Addresses->newEntity($cases[0]);
        $case = $this->Addresses->save($addressValido);
        $this->assertInstanceOf('Address\Model\Entity\Address', $case, 'O retorno do save no caso valido não foi o esperado');
        $this->assertEmpty($case->errors, 'caso valido retornou algum erro ');
        //case cidade não existente
        $case1 = $this->Addresses->newEntity($cases[3]);
        $result = $this->Addresses->save($case1);
        $this->assertFalse($result, 'caso invalido não retornou erro');
        $expected = ['city_id' => ['_existsIn' => 'This value does not exist']];
        $errors = $case1->errors();
        $this->assertEquals($expected, $errors, 'erros retornado não corresponde ao esperado');
    }
}
