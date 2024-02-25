<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Sarahheanan\PlentificCodingChallengeLibrary\User;
use Sarahheanan\PlentificCodingChallengeLibrary\DTO\UserDTO;

final class UserTest extends TestCase
{

    public function testGetUserReturnsADTO(): void
    {
        //mock decoded json response (we don't really care if guzzle works or not)
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

        //build mock of get method
        $apiMock = $this->getMockBuilder(User::class)
            ->onlyMethods(['fetchUserData'])
            ->getMock();

        //change its return output to simulate http response
        $apiMock->expects($this->any())
            ->method('fetchUserData')
            ->willReturn($apiTestData);

        $id = 2;

        $user = $apiMock->getUser($id);

        $this->assertIsObject($user);
        $this->assertInstanceOf(UserDTO::class, $user);
    }

    public function testUserReturnsListOfUsers(): void
    {

    }

    public function testUserListHasPagination(): void
    {

    }

    public function testUserCanCreateAUser(): void
    {

    }

    public function testExceptionIsThrownIfDataIsUnavailable(): void
    {

    }

    public function testExceptionIsThrownIfDataHasChanged(): void
    {

    }

    public function testExceptionThrownIsSpecificToDomain(): void
    {

    }
}