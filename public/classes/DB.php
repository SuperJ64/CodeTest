<?php

/**
 * Class DB
 * Database wrapper for accessing MySQL DB.
 */
class DB {
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'), Config::get('mysql/password') );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //maintain a single connection to our database
    //check if we're already connected if so, then just return current connection.
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    //query the database
    public function query($sql, $params = array()) {
        $this->_error = false;

        //check if we can prepare the statement for binding
        if ($this->_query = $this->_pdo->prepare($sql)) {

            //check if there's any parameters to bind
            if (count($params)) {
                $x = 1;
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            //execute the query
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    //return true if there was an error during query
    public function error() {
        return $this->_error;
    }

    //return results
    public function results() {
        return $this->_results;
    }

    //return only first result
    public function first() {
        return $this->results()[0];
    }
}