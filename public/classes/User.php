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
            Session::put('user', $user);

            return true;
        }

        return false;
    }

    public function addresses() {
        $user = $this->find(Session::get('user')->email);

        $stmt = 'SELECT a.street, a.city, a.state FROM addresses AS a LEFT OUTER JOIN user_address AS ua ON a.id = ua.address_id LEFT OUTER JOIN users AS u ON ua.user_id = u.id WHERE u.id = ? ORDER BY ua.created DESC ';

        $addresses = $this->_db->get($stmt, [$user->id]);

        return $addresses->results();

    }

    //add address to list of addresses validated by user
    public function addAddress($id) {

        $user_id = Session::get('user')->id;

        //check if address is already associated with user
        $adds = $this->_db->get('SELECT * FROM user_address WHERE user_id=? AND address_id=?', [$user_id, $id]);
        if (!$adds->count() > 0) {
            //if not then add.
            $this->_db->insert('INSERT INTO user_address (user_id, address_id) VALUES (?,?)', [$user_id, $id]);
        }

    }
}