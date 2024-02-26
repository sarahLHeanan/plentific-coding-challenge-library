<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary;

use Sarahheanan\PlentificCodingChallengeLibrary\DTO\UserDTO;

class User
{
    public $package = 'The package is loading';
    public $client;
    const API_URL = 'https://reqres.in/api/';
    

    public function testPackage() {
        echo $this->package;
    }

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }
    

    /**
     * Get list of users
     *
     * @return Array
     * @todo pagination
     * @todo validation/error handling
     */
    public function index()
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
     * Get User By Id
     * @param $id The user id
     * @param $query The request
     *
     * @return User $user
     * @todo functionality
     * @todo validation
     */
    public function fetchData(int $id, string $query)
    {
        $response = $this->client->request('GET', self::API_URL . $query . $id);

        $body = json_decode($response->getBody()->getContents(), true);

        if(!empty($body)) {
            return $body;
        } 
        else {
            echo 'User not available';
        }
    }

    public function getUser(int $id)
    {
        $body = $this->fetchData($id, 'users/');

        return new UserDTO(
            $body['data']['id'], 
            $body['data']['email'], 
            $body['data']['first_name'], 
            $body['data']['last_name'], 
            $body['data']['avatar']
        );
    }


    /**
     * Create a user
     *
     * @return void
     * @todo functionality
     * @todo are any of these params optional? make them nullable
     * @todo assume we won't actually have to pass the id, this is temporary
     * @todo validation/error handling
     */
    public function createUser(
        int $id, 
        string $email, 
        string $firstName, 
        string $lastName,
        string $avatar)
    {
        $user = new UserDTO(
            $id,
            $email,
            $firstName,
            $lastName,
            $avatar
        );

        $payload = json_encode($user);

        return $payload;
    }
}

?>