<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary;

use Sarahheanan\PlentificCodingChallengeLibrary\DTO\UserDTO;
use Sarahheanan\PlentificCodingChallengeLibrary\Exceptions\UserException;

class User
{
    public $package = 'The package is loading';
    public $client;
    const API_URL = 'https://reqres.in/api/';
    const NO_DATA = 'There is no data available';

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }

    public function testPackage() {
        echo $this->package;
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
     * Paginate data (users)
     * @param array $data User data
     * @param int $page The page to display
     * @param int $pageSize The number of records to display per page
     *
     * @return array|void
     * @todo exception handling
     */
    protected function paginate(array $data, int $page, int $pageSize)
    {
        $totalRecords = count($data);

        if($totalRecords == 0 || $page > $pageSize) {
            return;
        }

        $totalPages = ceil($totalRecords/$pageSize);

        $offset = ($page - 1) * $pageSize;

        return array_slice($data, $offset, $pageSize);
    }

    /**
     * Get list of users
     *
     * @return Array
     * 
     * @return array
     */
    public function index() : array
    {
        try {
            $body = $this->fetchData($id, 'users?page=2');

            if(empty($body['data'])) {
              //throw exception if no data
              throw new UserException(self::NO_DATA);
            }

            // loop through users and return each as DTO
            foreach($body['data'] as $data) { 
                $users[] =  new UserDTO(
                    $data['id'], 
                    $data['email'], 
                    $data['first_name'], 
                    $data['last_name'], 
                    $data['avatar']
                );
            }

            die(var_dump($users));

            // return $this->paginate($users);
          }
          
          catch (UserException $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * Get User as DTO
     * @param int $id The user id
     *
     * @return object UserDTO
     */
    public function getUser(int $id)
    {
        try {
            $body = $this->fetchData($id, 'users/');

            if(empty($body['data']) || is_null($body['data'])) {
     
                throw new UserException(self::NO_DATA);

                return;
            }

            return new UserDTO (
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