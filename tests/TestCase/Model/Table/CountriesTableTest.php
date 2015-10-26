<?php
namespace Address\Test\TestCase\Model\Table;

use Address\Model\Table\CountriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Address\Model\Table\CountriesTable Test Case
 */
class CountriesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.address.countries',
        //'plugin.address.states',
        //'plugin.address.cities',
        //'plugin.address.addresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Countries') ? [] : ['className' => 'Address\Model\Table\CountriesTable'];
        $this->Countries = TableRegistry::get('Countries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Countries);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    // public function testInitialize()
    // {
    //     //testes de inicialização n feitos
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
            'sigla' => 'Lorem ip'
        ];

        $errors = $this->Countries->validator()->errors($case1);
        $this->assertEmpty($errors, 'Caso valido retornou erro');

        $case2 = [
            'id' => 'safaf',
            'name' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            'sigla' => 'Lorem ip Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet'
        ];
        $errors = $this->Countries->validator()->errors($case2);
        $this->assertNotEmpty($errors, 'caso invalido não retornou erro');
        $expected = [
            'id' => ['valid' => 'The provided value is invalid'],
            'name' => ['maxLength' => 'The provided value is invalid'],
            'sigla' => ['maxLength' => 'The provided value is invalid']
        ];
        $this->assertEquals($expected, $errors, 'erros esperado não corresponde retornado');

        $case3 = [
            'id' => '',
            'name' => '',
            'sigla' => ''
        ];
        $errors = $this->Countries->validator()->errors($case3);
        $this->assertNotEmpty($errors, 'caso com todos os campos vazios não retornou erro');
        $expected = [
            'name' => ['_empty' => 'This field cannot be left empty' ],
            'sigla' => ['_empty' => 'This field cannot be left empty' ]
        ];
        $this->assertEquals($expected, $errors, 'erros não corresponde ao esperado para campo vazio');

        $case4 = [];
        $errors = $this->Countries->validator()->errors($case4);
        $this->assertNotEmpty($errors, 'não foi retornado erro para para array vazio');
        $expected = [
            'name' => ['_required' => 'This field is required'],
            'sigla' => ['_required' => 'This field is required']
        ];
        $this->assertEquals($expected, $errors, 'o erro retornado não foi o esperado para campos inexistentes');
    }
}
