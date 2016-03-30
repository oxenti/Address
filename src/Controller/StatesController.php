<?php
namespace Address\Controller;

use Address\Controller\AppController;
use Cake\Event\Event;

/**
 * States Controller
 *
 * @property \Address\Model\Table\StatesTable $States
 */
class StatesController extends AppController
{

    /**
     * beforeFilter Method
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
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
            
        if (! isset($this->request->params['country_id'])) {
            $this->paginate = [
                'finder' => $finder,
                'limit' => 30,
                'contain' => ['Countries'],
                'order' => ['States.name']
            ];

            if (isset($this->request->query['limt'])) {
                $this->paginate['limit'] = $this->request->query['limt'];
            }

            $this->set('states', $this->paginate($this->States));
            $this->set('_serialize', ['states']);
        } else {
            $this->set('states', $this->States->find($finder)->where(['country_id' => $this->request->params['country_id']]));
            $this->set('_serialize', ['states']);
        }
    }
}
