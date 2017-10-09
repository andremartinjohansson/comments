<?php

namespace Anax\Comments;

use PHPUnit\Framework\TestCase;

class CommentsControllerTest extends TestCase
{
    protected static $di;
    protected static $comments;
    protected static $db;
    protected static $session;

    public static function setUpBeforeClass()
    {
        self::$db = new \Anax\Database\DatabaseQueryBuilder();
        self::$db->configure("database2.php");
        self::$di = new \Anax\DI\DIFactoryConfig("di.php");
        self::$comments = new \Anax\Comments\CommentsController();
        self::$comments->setDI(self::$di);
        self::$comments->init(self::$db);
        self::$session = self::$di->get("session");
        self::$comments->inject(self::$session);
        $loggedIn = ["name" => "test", "email" => "test@test", "role" => "user"];
        self::$session->set("user", $loggedIn);
    }

    public function testInit()
    {
        self::$comments->init(self::$db);
    }

    public function testInject()
    {
        self::$comments->inject(self::$session);
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Anax\Comments\CommentsController", self::$comments);
    }

    public function testGet()
    {
        self::$comments->get("1");
    }

    public function testAdd()
    {
        $_POST["article"] = "1";
        $_POST["comment"] = "test";
        self::$comments->add();
    }

    public function testEdit()
    {
        $comment = new Comment();
        $comment->setDb(self::$db);
        $comment = $comment->find("author", "test");
        $_POST["id"] = $comment->id;
        $_POST["comment"] = "testedited";
        self::$comments->edit();
    }

    public function testDelete()
    {
        $comment = new Comment();
        $comment->setDb(self::$db);
        $comment = $comment->find("author", "test");
        $_GET['id'] = $comment->id;
        self::$comments->delete();
    }

    public function testCommentSection()
    {
        self::$comments->addCommentSection();
    }
}
