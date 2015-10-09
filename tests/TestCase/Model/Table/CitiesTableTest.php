<?php
namespace Address\Test\TestCase\Model\Table;

use Address\Model\Table\CitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Address\Model\Table\CitiesTable Test Case
 */
class CitiesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.cities',
        'plugin.address.states',
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
        $config = TableRegistry::exists('Cities') ? [] : ['className' => 'Address\Model\Table\CitiesTable'];
        $this->Cities = TableRegistry::get('Cities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cities);

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
            'state_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'uf' => 'Lo'
        ];
        $errors = $this->Cities->validator()->errors($case1);
        $this->assertEmpty($errors, 'Caso valido retornou erro');

        $case2 = [
            'id' => 'safaf',
            'name' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit',
            'uf' => 'Lor Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            'state_id' => 'cscsafvvsda'
        ];
        $errors = $this->Cities->validator()->errors($case2);
        $this->assertNotEmpty($errors, 'caso invalido não retornou erro');
        $expected = [
            'id' => ['valid' => 'The provided value is invalid'],
            'name' => ['maxLength' => 'The provided value is invalid'],
            'uf' => ['maxLength' => 'The provided value is invalid'],
            'state_id' => ['valid' => 'The provided value is invalid'],
        ];
        $this->assertEquals($expected, $errors, 'erros esperado não corresponde retornado');
        $case3 = [
            'id' => '',
            'name' => '',
            'uf' => '',
            'state_id' => ''
        ];
        $errors = $this->Cities->validator()->errors($case3);
        $this->assertNotEmpty($errors, 'caso com todos os campos vazios não retornou erro');
        $expected = [
            'name' => ['_empty' => 'This field cannot be left empty' ],
            'uf' => ['_empty' => 'This field cannot be left empty' ],
            'state_id' => ['_empty' => 'This field cannot be left empty' ]
        ];
        $this->assertEquals($expected, $errors, 'erros não corresponde ao esperado para campo vazio');

        $case4 = [];
        $errors = $this->Cities->validator()->errors($case4);
        $this->assertNotEmpty($errors, 'não foi retornado erro para para array vazio');
        $expected = [
            'name' => ['_required' => 'This field is required'],
            'uf' => ['_required' => 'This field is required'],
            'state_id' => ['_required' => 'This field is required']
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
            'state_id' => 1
        ];
        $case1 = $this->Cities->newEntity($case1);
        $result = $this->Cities->save($case1);
        $this->assertInstanceOf('Address\Model\Entity\City', $result, 'não retornou uma instacia de state');

        $case2 = [
            'name' => 'Lorem ipsum dolor sit',
            'uf' => 'Lo',
            'state_id' => 44
        ];
        $case2 = $this->Cities->newEntity($case2);
        $result = $this->Cities->save($case2);
        $this->assertFalse($result, __('Saving invalid cities'));
        
        $expected = ['state_id' => ['_existsIn' => 'This value does not exist']];
        $errors = $case2->errors();
        $this->assertEquals($expected, $errors, __('_existsIn validation for state_id failed'));
    }
}
