<?php

namespace model;

require_once PATH_APP . "/model/DBMS.php";

class UserManager extends DBMS {

    public function create($user) {
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        parent::query("INSERT INTO user VALUES ('". $user->getUsername() ."', '". $pass ."')");
    }

    public function verify($user) {
        $row = mysqli_fetch_assoc(parent::query("SELECT * FROM user WHERE username='". $user->getUsername() ."'"));
        return password_verify($user->getPassword(), $row['password']);
    }

}


class User {

    private $username;
    private $password;

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $pass
     */
    public function setPassword($password) {
        $this->password = $password;
    }

}