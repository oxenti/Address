<?php

namespace Address\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
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
     * beforeFilter Method
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['*']);
    }
}
