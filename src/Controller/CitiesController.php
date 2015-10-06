<?php
namespace Address\Controller;

use Address\Controller\AppController;

/**
 * Cities Controller
 *
 * @property \Address\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $finder = !isset($this->request->query['finder'])?'All': $this->request->query['finder'];
        $this->paginate = [
            'finder' => $finder,
            'contain' => ['States', 'States.Countries'],
            'order' => ['Cities.name'],
        ];
        if (isset($this->request->params['state_id'])) {
            $this->paginate['conditions'] = ['States.id' => $this->request->params['state_id']];
        }
        $this->set('cities', $this->paginate($this->Cities));
        $this->set('_serialize', ['cities']);
    }
}
