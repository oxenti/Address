<?php
namespace Address\Controller;

use Address\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Addresses Controller
 *
 * @property \Address\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $finder = !isset($this->request->query['finder'])?'all': $this->request->query['finder'];
        $this->paginate = [
            'finder' => $finder,
            'contain' => ['Cities', 'Cities.States', 'Cities.States.Countries']
        ];
        if (isset($this->request->params['city_id'])) {
            $this->paginate['conditions'] = ['city.id' => $this->request->params['city_id']];
        }
        try {
            $addresses = $this->paginate($this->Addresses);
        } catch (NotFoundException $e) {
            throw new NotFoundException(' The Address could not finded ');
        }
        
        $this->set('addresses', $addresses);
        $this->set('_serialize', ['addresses']);
    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => ['Cities', 'Cities.States', 'Cities.States.Countries']
        ]);
        $this->set('address', $address);
        $this->set('_serialize', ['address']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $address = $this->Addresses->newEntity();
        if ($this->request->is('post')) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $message = 'The tutor has been saved.';
                $this->set([
                   'success' => true,
                   'message' => $message,
                   'id' => $address->id,
                   '_serialize' => ['success', 'message', 'id'],
                ]);
            } else {
                throw new NotFoundException('The tutor could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $message = 'The tutor has been saved.';
                $this->set([
                   'success' => true,
                   'message' => $message,
                   'id' => $address->id,
                   '_serialize' => ['success', 'message', 'id'],
                ]);
            } else {
                throw new NotFoundException('The tutor could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $address = $this->Addresses->get($id);
        if ($this->Addresses->delete($address)) {
            $message = 'The user has been saved.';
            $this->set([
               'message' => $message,
               '_serialize' => ['message']
            ]);
        } else {
            throw new NotFoundException('The user could not be saved. Please, try again.');
        }
    }
}
