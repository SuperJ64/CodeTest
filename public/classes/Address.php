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

            //not in cache, check if in db
            $id = $this->inDB($street, $city, $state);
            if( is_null($id) ) {

                //if not in either call api
                $curl = curl_init();

                $url = Config::get('google/url') . "?" . Config::get('google/api_key') . "&address=" . urlencode($key);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($curl);

                curl_close($curl);
                $result = json_decode($result);

                //in the results if the status is okay we found a match
                //check the type, if its a route (a road) then reject.
                if ($result->status === "OK") {
                    echo "THIS IS OK";

                    $data = $result->results[0];

                    if ( $data->types[0] != "route") {

                        //add to db
                        $id = $this->create([$this->dbFormat($street), $this->dbFormat($city), strtoupper($this->dbFormat($state))]);
                    } else {
                        return null;
                    }
                }


            }
            //add to cache
            $this->_cache->add($key, $id);


        }

        return $id;
    }

    //helper function - format string for db storage
    //removes all punctuation and converts first letter of each word to cap.
    private function dbFormat ($string) {
       $temp = preg_replace("/[^a-zA-Z 0-9]+/", "", $string);
       return ucwords($temp);
    }

    //helper function - check if address is in db
    //returns id if it is, else return null.
    private function inDB($street, $city, $state) {
        $st = $this->dbFormat($street);
        $c = $this->dbFormat($city);
        $s = strtoupper($this->dbFormat($state));

        $result = $this->_db->get('SELECT * FROM addresses WHERE street=? and city=? and state=?', [$st, $c, $s]);

        if ($result->count() >0 ) {
            return $result->first()->id;
        }

        return null;
    }

}