<?php
namespace Address\Controller;

use Address\Controller\AppController;

/**
 * States Controller
 *
 * @property \Address\Model\Table\StatesTable $States
 */
class StatesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Countries']
        ];
        $this->set('states', $this->paginate($this->States->find('list')));
        $this->set('_serialize', ['states']);
    }
}
