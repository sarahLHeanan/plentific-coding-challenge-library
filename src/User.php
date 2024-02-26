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
     * Set data for API
     * Payload for POST request
     * This is specific to one request but would be more reusable if there were more
     * 
     * @param string $name
     * @param string $jobTitle
     *
     * @return array
     */
    protected function setData(string $name, string $jobTitle) : array
    {
        $payload = json_encode([$name, $job]);

        return json_decode($this->client->request('POST', self::API_URL . 'api/users', $payload));
    }

    /**
     * Paginate data (users)
     * @param array $data User data
     * @param int $page The page to display
     * @param int $pageSize The number of records to display per page
     *
     * @return array|void
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
     * @param int $page The page to display (pagination)
     * @param int $pageSize The number of records to display per page (pagination)
     * 
     * @return array
     */
    public function index(int $page, int $pageSize) : array
    {
        try {
            $body = $this->fetchData($id, 'users?page=2');

            if(empty($body['data'])) {
              //throw exception if no data
              throw new UserException(self::NO_DATA);
            }

            // loop through users and return each as DTO
            foreach($body['data'] as $data) { 
                $users[] = new UserDTO(
                    $data['id'], 
                    $data['email'], 
                    $data['first_name'], 
                    $data['last_name'], 
                    $data['avatar']
                );
            }

            return $this->paginate($users, $page, $pageSize);
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
    public function getUser(int $id) : UserDTO | array
    {
        try {
            $body = $this->fetchData($id, 'users/');

            if(empty($body['data']) || is_null($body['data'])) {
     
                throw new UserException(self::NO_DATA);

                return [];
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
     * @param $name Name
     * @param $job Job title
     *
     * @return int $id
     */
    public function createUser(string $name, string $job) : int | array
    {
        try {
            $body = $this->setData($name, $job);

            if (empty($body) || is_null($body)) {
     
                throw new UserException(self::NO_DATA);

                return [];
            }

            return $body['id'];
          }
          
          catch (UserException $e) {
            echo $e->errorMessage();
        }
    }
}

?>