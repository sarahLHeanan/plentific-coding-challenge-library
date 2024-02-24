<?php

class RetrieveUsers
{
    public $package = 'the package is loading';
    public $client;
    const API_URL = 'https://reqres.in/';
    

    public function testPackage() {
        echo $this->package;
    }

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }
    

    /**
     * Get User By Id
     * @param $id The user id
     *
     * @return User $user
     * @todo functionality
     * @todo validation
     */
    public function getUser(int $id)
    {

    }

    /**
     * Get list of users
     *
     * @return Array
     * @todo basic functionality
     * @todo pagination
     * @todo validation/error handling
     */
    public function getUsers()
    {
        $response = $this->client->request('GET', self::API_URL);

        var_dump($response);
    }

    /**
     * Create a user
     *
     * @return void
     * @todo functionality
     * @todo validation/error handling
     */
    public function createUser()
    {

    }
}

?>