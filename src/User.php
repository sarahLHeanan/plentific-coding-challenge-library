<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary;

use Sarahheanan\PlentificCodingChallengeLibrary\DTO\UserDTO;
use Sarahheanan\PlentificCodingChallengeLibrary\Exceptions\UserException;

class User
{
    public $package = 'The package is loading';
    public $client;
    const API_URL = 'https://reqres.in/api/';

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }

    public function testPackage() {
        echo $this->package;
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
     * Fetch data from API
     * @param int|null $id The user id
     * @param string $query The request
     *
     * @return array
     * @todo exception handling
     */
    protected function fetchData(int $id = null, string $query) : array
    {
        $response = $this->client->request('GET', self::API_URL . $query . $id);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get User as DTO
     * @param int $id The user id
     *
     * @return object
     */
    public function getUser(int $id)
    {
        try {
            $body = $this->fetchData($id, 'users/');

            if(empty($body)) {
              //throw exception if no data
              throw new UserException($email);
            }

            return new UserDTO(
                $body['data']['id'], 
                $body['data']['email'], 
                $body['data']['first_name'], 
                $body['data']['last_name'], 
                $body['data']['avatar']
            );
          }
          
          catch (UserException $e) {
            echo $e->errorMessage();
          }
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