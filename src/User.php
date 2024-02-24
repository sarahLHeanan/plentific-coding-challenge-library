<?php

class User
{
    public $package = 'the package is loading';
    public $client;
    const API_URL = 'https://reqres.in/api/';
    

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
        $response = $this->client->request('GET', self::API_URL . 'users/' . $id);

        $body = json_decode($response->getBody()->getContents(), true);

        if(!empty($body)) {
            return new UserDTO(
                $body['data']['id'], 
                $body['data']['email'], 
                $body['data']['first_name'], 
                $body['data']['last_name'], 
                $body['data']['avatar']
            );
        } 
        else {
            echo 'User not available';
        }
    }

    /**
     * Get list of users
     *
     * @return Array
     * @todo pagination
     * @todo validation/error handling
     */
    public function getUsers()
    {
        $response = $this->client->request('GET', self::API_URL . 'users?page=2');

        $body = json_decode($response->getBody()->getContents(), true);

        if(!empty($body)) {
            var_dump($body);
        } 
        else {
            echo 'No users available';
        }
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