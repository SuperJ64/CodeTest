<?php
/**
 * Created by PhpStorm.
 * User: mikew
 * Date: 10/10/2017
 * Time: 3:28 PM
 */

class Address
{
    private $_db;
    private $_cache;

    public function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_cache = Cache::getInstance();
    }

    private function create($fields)
    {

        $address = $this->_db->insert('INSERT INTO addresses (street, city, state) VALUES (?,?,?)', $fields);
        return $address->id();
    }

    //turn an address into a key
    public static function keyify($street, $city, $state) {
        $key = $street . ", " . $city . ", " . $state;

        //strip all punctuation and convert all characters to lowercase to eliminate possible differences
        $key = preg_replace("/[^a-zA-Z0-9]+/", "", $key);
        $key = strtolower($key);

        return $key;
    }

    //get the table id for an address, if its cached
    //otherwise validate, if valid create address and return id else return null (address not valid)
    public function getID($street, $city, $state)
    {
        $key = $this->keyify($street, $city, $state);

        $id = $this->_cache->get($key);

        if (is_null($id)) {
            $curl = curl_init();

            $url = Config::get('google/url')."?".Config::get('google/api_key')."&address=".urlencode($key);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);

            curl_close($curl);
            $result = json_decode($result);

            if (isset($result->results[0]->partial_match)) {
                //google will return partial match for all results that aren't a direct match
                return null;
            }

            $id = $this->create([ucwords($street),ucwords($city), strtoupper($state)]);
            $this->_cache->add($key, $id);


        }

        return $id;
    }

}