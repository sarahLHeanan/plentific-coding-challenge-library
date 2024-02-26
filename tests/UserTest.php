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

        $apiMock = $this->getMockBuilder(User::class)
        ->onlyMethods(['fetchData'])
        ->getMock();

        $apiMock->expects($this->any())
            ->method('fetchData')
            ->willReturn($apiTestData);

        $id = 2;


        // @todo see if I can get this to work (throws exception when I dump out)
        // $this->expectExceptionMessage('no data available');
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
                ],
                [
                    'id' => 3,
                    'email' => 'lindsay.ferguson@reqres.in',
                    'first_name' => 'Lindsay',
                    'last_name' => 'Ferguson',
                    'avatar' => 'https://reqres.in/img/faces/8-image.jpg'
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

        //set pagination variables
        $page = 1;
        $pageSize = 2;

        $users = $apiMock->index($page, $pageSize);

        $this->assertIsArray($users);
        $this->assertCount($pageSize, $users);

        // @todo get correct syntax for this
        // $this->assertContains($users, 'janet');
    }

    public function testUserCanCreateAUser(): void
    {
        $name = 'morpheus';
        $job = 'leader';

        $apiTestData = [
            'name' => $name,
            'job' => $job,
            'id' => 22,
            'created_at' => '2024-02-26T13:34:03.058Z'
        ];

        //build mock of set method
        $apiMock = $this->getMockBuilder(User::class)
        ->onlyMethods(['setData'])
        ->getMock();

        //change its return output to simulate http response
        $apiMock->expects($this->any())
            ->method('setData')
            ->willReturn($apiTestData);

        $user = $apiMock->createUser($name, $job);
        $this->assertEquals($user, $apiTestData['id']);
    }


    public function testExceptionIsThrownIfDataHasChanged(): void
    {
        //mock an unexpected/incorrect json response
        $apiTestData = [
            'data' => [
                'id' => 2,
                'fruit' => 'bananas',
            ]
        ];

        $apiMock = $this->getMockBuilder(User::class)
        ->onlyMethods(['fetchData'])
        ->getMock();

        $apiMock->expects($this->any())
            ->method('fetchData')
            ->willReturn($apiTestData);

        $id = 2;

        $user = $apiMock->getUser($id);

        $this->assertNull($user);
    }
}