<?php
session_start();

$GLOBALS['config'] = array(
  'mysql' => array(
      'host' => '127.0.0.1',
      'username' => 'root',
      'password' => 'root',
      'db' => 'scotchbox'
  ),

    'session' => array(
        'session_name' => 'user'
    )
);

spl_autoload_register(function($class) {
    require_once 'classes/'.$class.'.php';
});