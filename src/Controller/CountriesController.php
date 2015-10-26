<?php
namespace Address\Controller;

use Address\Controller\AppController;

/**
 * Countries Controller
 *
 * @property \Address\Model\Table\CountriesTable $Countries
 */
class CountriesController extends AppController
{

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
