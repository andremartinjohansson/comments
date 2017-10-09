<?php

namespace Anax\User;

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    protected static $di;
    protected static $userController;

    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("di.php");
        self::$userController = new \Anax\User\UserController();
        self::$userController->setDI(self::$di);
        self::$userController->init();
    }

    public function testIndex()
    {
        self::$userController->getIndex();
    }
}
