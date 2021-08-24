<?php

namespace App\Tests\Service;

use App\Service\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UserTest extends TestCase
{

    public function testEmptyCreate()
    {
        $request = $this->createMock(Request::class);
        $user = new User();
        self::assertFalse($user->createUser($request));
    }

    public function testEmptyPasswordCreate()
    {
        $request = $this->createMock(Request::class);
        $map = [['email', 'asd'], ['password', '']];
        $request->expects($this->any())->method('get')->will($this->returnValueMap($map));
        $user = new User();
        self::assertFalse($user->createUser($request));
    }

    public function testCreateUserThatAlreadyExists()
    {
        $request = $this->createMock(Request::class);
        $map = [['email', 'asd'], ['password', 'asd']];
        $request->expects($this->any())->method('get')->will($this->returnValueMap($map));
        $user = new User();
        self::assertFalse($user->createUser($request));
    }

}
