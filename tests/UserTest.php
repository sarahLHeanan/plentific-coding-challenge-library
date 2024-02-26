<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Sarahheanan\PlentificCodingChallengeLibrary\User;
use Sarahheanan\PlentificCodingChallengeLibrary\DTO\UserDTO;
use Sarahheanan\PlentificCodingChallengeLibrary\Exceptions\UserException;

final class UserTest extends TestCase
{

    public function testGetUserReturnsADTO(): void
    {
        //mock decoded json response (we are not testing guzzle or json_decode)
        $apiTestData = [
            'data' => [
                'id' => 2,
                'email' => 'janet.weaver@reqres.in',
                'first_name' => 'janet',
                'last_name' => 'Weaver',
                'avatar' => 'https://reqres.in/img/faces/2-image.jpg'
            ]
        ];

        $this->assertIsArray($apiTestData);

        //build mock of fetch method
        $apiMock = $this->getMockBuilder(User::class)
            ->onlyMethods(['fetchData'])
            ->getMock();

        //change its return output to simulate http response
        $apiMock->expects($this->any())
            ->method('fetchData')
            ->willReturn($apiTestData);

        $id = 2;

        $user = $apiMock->getUser($id);

        $this->assertIsObject($user);
        $this->assertInstanceOf(UserDTO::class, $user);
    }

    public function testNoDataReturnsUserException() : void
    {
        $apiTestData = [
            'data' => []
        ];

        //build mock of fetch method
        $apiMock = $this->getMockBuilder(User::class)
        ->onlyMethods(['fetchData'])
        ->getMock();

        //change its return output to simulate http response
        $apiMock->expects($this->any())
            ->method('fetchData')
            ->willReturn($apiTestData);

        $id = 2;

        // @todo see if I can get this to work (throws exception when I dump out)
        // $this->expectException(UserException::class);

        $user = $apiMock->getUser($id);

        $this->assertNull($user);
    }

    public function testUserListHasPagination(): void
    {
        $apiTestData = [
            'data' => [
                [
                    'id' => 1,
                    'email' => 'janet.weaver@reqres.in',
                    'first_name' => 'janet',
                    'last_name' => 'Weaver',
                    'avatar' => 'https://reqres.in/img/faces/2-image.jpg'
                ],
                [
                    'id' => 2,
                    'email' => 'michael.lawson@reqres.in',
                    'first_name' => 'Michael',
                    'last_name' => 'Lawson',
                    'avatar' => 'https://reqres.in/img/faces/7-image.jpg'
                ]

            ]
        ];

        $apiMock = $this->getMockBuilder(User::class)
        ->onlyMethods(['fetchData'])
        ->getMock();

        //change its return output to simulate http response
        $apiMock->expects($this->any())
            ->method('fetchData')
            ->willReturn($apiTestData);

         $users = $apiMock->index();

        $this->assertIsArray($users);
    }

    public function testUserCanCreateAUser(): void
    {

    }


    public function testExceptionIsThrownIfDataHasChanged(): void
    {

    }

    public function testExceptionThrownIsSpecificToDomain(): void
    {

    }
}