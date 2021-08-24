<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UserControllerTest extends TestCase
{
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function testEmptyRequestTransform(): void
    {
        $request_stack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);
        $controller = new UserController($request_stack);
        $this->assertEquals($request, $this->invokeMethod($controller, 'transformJsonBody', [$request]));

    }
}
