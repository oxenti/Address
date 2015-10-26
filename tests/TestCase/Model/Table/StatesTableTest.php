<?php
namespace Address\Test\TestCase\Model\Table;

use Address\Model\Table\StatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Address\Model\Table\StatesTable Test Case
 */
class StatesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.states',
        'plugin.address.countries',
        'plugin.address.cities',
        'plugin.address.addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('States') ? [] : ['className' => 'Address\Model\Table\StatesTable'];
        $this->States = TableRegistry::get('States', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->States);

        parent::tearDown();
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
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $case1 = [
            'name' => 'Lorem ipsum dolor sit amet',
            'uf' => 'Lor',
            'country_id' => 1
        ];
        $errors = $this->States->validator()->errors($case1);
        $this->assertEmpty($errors, 'Caso valido retornou erro');

        $case2 = [
            'id' => 'safaf',
            'name' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit',
            'uf' => 'Lor Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            'country_id' => 'cscsafvvsda'
        ];
        $errors = $this->States->validator()->errors($case2);
        $this->assertNotEmpty($errors, 'caso invalido não retornou erro');
        $expected = [
            'id' => ['valid' => 'The provided value is invalid'],
            'name' => ['maxLength' => 'The provided value is invalid'],
            'uf' => ['maxLength' => 'The provided value is invalid'],
            'country_id' => ['valid' => 'The provided value is invalid'],
        ];
        $this->assertEquals($expected, $errors, 'erros esperado não corresponde retornado');
        $case3 = [
            'id' => '',
            'name' => '',
            'uf' => '',
            'country_id' => ''
        ];
        $errors = $this->States->validator()->errors($case3);
        $this->assertNotEmpty($errors, 'caso com todos os campos vazios não retornou erro');
        $expected = [
            'name' => ['_empty' => 'This field cannot be left empty' ],
            'uf' => ['_empty' => 'This field cannot be left empty' ],
            'country_id' => ['_empty' => 'This field cannot be left empty' ]
        ];
        $this->assertEquals($expected, $errors, 'erros não corresponde ao esperado para campo vazio');

        $case4 = [];
        $errors = $this->States->validator()->errors($case4);
        $this->assertNotEmpty($errors, 'não foi retornado erro para para array vazio');
        $expected = [
            'name' => ['_required' => 'This field is required'],
            'uf' => ['_required' => 'This field is required'],
            'country_id' => ['_required' => 'This field is required']
        ];
        $this->assertEquals($expected, $errors, 'o erro retornado não foi o esperado para campos inexistentes');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $case1 = [
            'name' => 'Lorem ipsum dolor sit amet',
            'uf' => 'Lor',
            'country_id' => 1
        ];
        $case1 = $this->States->newEntity($case1);
        $result = $this->States->save($case1);
        $this->assertInstanceOf('Address\Model\Entity\State', $result, 'não retornou uma instacia de state');

        $case2 = [
            'name' => 'Lorem ipsum dolor sit',
            'uf' => 'Lo',
            'country_id' => 44
        ];
        $case2 = $this->States->newEntity($case2);
        $result = $this->States->save($case2);
        $this->assertFalse($result, 'entrada invalida não retornou false no save');
        $expected = ['country_id' => ['_existsIn' => 'This value does not exist']];
        $errors = $case2->errors();
        $this->assertEquals($expected, $errors, 'erros retornado não corresponde ao esperado');
    }
}
