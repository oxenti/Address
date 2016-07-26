<?php
namespace Address\Controller;

use Address\Controller\AppController;
use Cake\Event\Event;

/**
 * Cities Controller
 *
 * @property \Address\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController
{
    /**
     * beforeFilter Method
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['view', 'index']);
    }

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

            if (isset($this->request->query['limit'])) {
                $this->paginate['limit'] = $this->request->query['limt'];
            }

            if (isset($this->request->query['name'])) {
                $this->paginate['conditions'] = ['Cities.name LIKE' => $this->request->query['name'] . '%'];
            }

            $this->set('cities', $this->paginate($this->Cities));
            $this->set('_serialize', ['cities']);
        } else {
            $this->set('cities', $this->Cities->find($finder)->where(['state_id' => $this->request->params['state_id']]));
            $this->set('_serialize', ['cities']);
        }
    }

     /**
     * view method
     *
     * @return void
     */
    public function view($cityId = null)
    {
        if($cityId) {
            $this->set('city', $this->Cities->get($cityId));
            $this->set('_serialize', ['city']);
        }
        else {
            $this->set('city', []);
            $this->set('_serialize', ['city']);
        }
    }
}
