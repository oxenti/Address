<?php
namespace Address\Controller;

use Address\Controller\AppController;
use Cake\Event\Event;

/**
 * Countries Controller
 *
 * @property \Address\Model\Table\CountriesTable $Countries
 */
class CountriesController extends AppController
{

    /**
     * beforeFilter Method
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['*']);
    }
    
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $countries = $this->paginate($this->Countries->find('list'))->toArray();
        $this->set('countries', $countries);
        $this->set('_serialize', ['countries']);
    }
}
