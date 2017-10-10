<?php
/**
 * Created by PhpStorm.
 * User: mikew
 * Date: 10/10/2017
 * Time: 3:13 PM
 */

class Cache
{
    private static $_instance = null;
    private $_redis;

    private function __construct() {
        $this->_redis = new Predis\Client(Config::get('redis'));
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Cache();
        }

        return self::$_instance;
    }

    public function add($key, $value) {
        $this->_redis->append($key, $value);
    }

    public function get($key) {
        return $this->_redis->get($key);
    }


}