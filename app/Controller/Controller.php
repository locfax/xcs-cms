<?php

namespace Controller;

class Controller extends \Xcs\Controller {

    //用户信息
    protected $login_user = null;

    function __construct($controllerName, $actionName) {
        parent::__construct($controllerName, $actionName);
    }

    final function checklogin() {
        if ($this->login_user) {
            return $this->login_user;
        }
        $this->login_user = \Xcs\User::getUser();
        return $this->login_user;
    }
}