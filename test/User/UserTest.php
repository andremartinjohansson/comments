<?php

namespace Anax\User;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected static $di;

    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("di.php");
    }

    public function testPassword()
    {
        $user = new User();
        $user->setDb(self::$di->get("db"));
        $user->acronym = "test";
        $user->setPassword("abstract");
        $user->email = "test@test";
        $user->role = "user";
        $user->save();

        $user->verifyPassword("test", "abstract");

        $user->delete();
    }
}
