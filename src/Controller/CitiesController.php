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
        $full = isset($this->request->query['complete'])?$this->request->query['complete']:false;
        $finder = $full ? 'all' : 'list';
            
        if (! isset($this->request->params['state_id'])) {
            $this->paginate = [
                'finder' => $finder,
                'contain' => ['States', 'States.Countries'],
                'order' => ['Cities.name'],
            ];

            if (isset($this->request->query['limt'])) {
                $this->paginate['limit'] = $this->request->query['limt'];
            }

            $this->set('cities', $this->paginate($this->Cities));
            $this->set('_serialize', ['cities']);
        } else {
            $this->set('cities', $this->Cities->find($finder)->where(['state_id' => $this->request->params['state_id']]));
            $this->set('_serialize', ['cities']);
        }
    }
}
