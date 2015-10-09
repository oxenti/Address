<?php
namespace Address\Controller;

use Address\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;

/**
 * Addresses Controller
 *
 * @property \Address\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController
{
    /**
     * isAuthorized method handles authorization inside the controller
     * @param User $user  User array provided from the Auth component
     * @return bool
     */
    public function isAuthorized($user)
    {
        return true;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        // $list = isset($this->request->query['list'])?$this->request->query['list']:false;
        // $finder = $list ? 'list' : 'all';

        $limit = isset($this->request->query['limt'])?$this->request->query['limit']:50;
        $this->paginate = [
            'limit' => $limit
        ];

        $this->paginate = [
            'contain' => ['Cities', 'Cities.States', 'Cities.States.Countries'],
            // 'finder' => $finder,
            'limit' => $limit
        ];

        // if ($finder == 'list') {
        //     $this->paginate['fields'] = ['id', 'full_address'];
        // }

        if (isset($this->request->params['city_id'])) {
            $this->paginate['conditions'] = ['city.id' => $this->request->params['city_id']];
        }

        try {
            $addresses = $this->paginate($this->Addresses);
        } catch (BadRequestException $e) {
            throw new BadRequestException();
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
    public function view($addressId = null)
    {
        $address = $this->Addresses->get($addressId, [
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
                $message = 'The address has been saved.';
                $this->set([
                   'success' => true,
                   'message' => $message,
                   'id' => $address->id,
                   '_serialize' => ['success', 'message', 'id'],
                ]);
            } else {
                throw new BadRequestException('The address could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\BadRequestException When record not updated.
     */
    public function edit($id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $message = __('The address has been updated');
                $this->set([
                   'success' => true,
                   'message' => $message,
                   'id' => $address->id,
                   '_serialize' => ['success', 'message', 'id'],
                ]);
            } else {
                throw new BadRequestException(__('The address could not be updated'));
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $addressId Address id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\BadRequestException When record not removed.
     */
    public function delete($addressId = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $address = $this->Addresses->get($addressId);
        if ($this->Addresses->delete($address)) {
            $message = __('The address has been removed');
            $this->set([
               'message' => $message,
               '_serialize' => ['message']
            ]);
        } else {
            throw new BadRequestException(__('The address could not be removed'));
        }
    }
}
