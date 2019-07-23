<?php
namespace controller;

use model\User;
require_once PATH_APP . "/model/UserManager.php";

class IndexController extends ApplicationController {

    private $userManager;

    public function __construct() {
        $this->userManager = new \model\UserManager();
    }

    public function signup() {
        parent::response('signup.html.twig');
    }

    public function save() {
        $user = new User();
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        $this->userManager->create($user);
        $_SESSION['username'] = $user->getUsername();
        parent::redirect("/");
    }

    public function login() {
        if (isset($_SESSION['username'])) {
            parent::redirect("/");
        }
        else {
            parent::response('login.html.twig');
        }
    }

    public function verify() {
        $user = new User();
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        if ($this->userManager->verify($user)) {
            $_SESSION['username'] = $user->getUsername();
            parent::redirect("/");
        }
        else {
            parent::redirect("/login/");
        }
    }


    public function logout() {
        session_destroy();
        parent::redirect("/login/");
    }


}