<?php

class User {
    private $_db;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
    }

    public function create($fields) {
        if (!$this->_db->insert('INSERT INTO users (email, password, First_Name, Last_name) VALUES (?,?,?,?)',$fields)) {
            throw new Exception('There was an error creating the account');
        }
    }

    public function find($email) {
        $user = $this->_db->get('SELECT * FROM users WHERE email=?', [$email]);
        if ($user->count() > 0) {
            return $user->first();
        }

        return null;
    }

    public function login($email, $password) {
        $user = $this->find($email);

        if (password_verify($password, $user->password)) {
            //set session data for later use;
            Session::put('id', $user->id);
            Session::put('fname', $user->first_name);
            Session::put('lname', $user->last_name);
            Session::put('email', $user->email);

            return true;
        }

        return false;
    }
}