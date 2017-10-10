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
    ),
    'redis' => array(
        "scheme" => "tcp",
        "host" => "localhost",
        "port" =>  6379,
        "persistent" => 1
    ),
    'google' => array(
        'url' => 'https://maps.googleapis.com/maps/api/geocode/json',
        'api_key' => 'AIzaSyCUv4UoKIw86hrknKC-PcDN5Yajk0uATzU'
    )
);

require_once ('../vendor/predis/predis/autoload.php');

spl_autoload_register(function($class) {
    require_once 'classes/'.$class.'.php';
});