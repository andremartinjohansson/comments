<?php

namespace Anax\User;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testPassword()
    {
        $user = new User();
        $user->setPassword("abstract");
    }
}
