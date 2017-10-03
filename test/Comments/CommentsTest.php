<?php

namespace Anax\Comments;

use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    protected static $session;
    protected static $di;
    protected static $comments;
    protected static $user;

    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("di.php");
        self::$comments = new Comments();
        self::$comments->init(self::$di->get("db"));
        self::$user = ["name" => "test", "email" => "test@test", "role" => "user"];
        self::$session = self::$di->get("session");
    }

    public function testInit()
    {
        self::$comments->init(self::$di->get("db"));
    }

    public function testGetComment()
    {
        $text = self::$comments->getComment("1", self::$di->get("db"));
        $this->assertEquals("Hej", $text->comment);
    }

    public function testGetAllComment()
    {
        self::$comments->getAllComments();
    }

    public function testAddComment()
    {
        $content = array(
            'id' => "1",
            'article' => "1",
            'author' => self::$user["name"],
            'email' => self::$user["email"],
            'comment' => "testytest");

        self::$comments->addComment($content, self::$di->get("db"), self::$user);

        $comment = new Comment();
        $comment->setDb(self::$di->get("db"));
        $comment = $comment->find("author", "test");

        $this->assertEquals(self::$user["name"], $comment->author);
        $this->assertEquals(self::$user["email"], $comment->email);
        $this->assertEquals("testytest", $comment->comment);
    }

    public function testEditComment()
    {
        $comment = new Comment();
        $comment->setDb(self::$di->get("db"));
        $comment = $comment->find("author", "test");
        self::$comments->editComment($comment->id, "editedtestytest", self::$di->get("db"));

        $comment = new Comment();
        $comment->setDb(self::$di->get("db"));
        $comment = $comment->find("author", "test");

        $this->assertEquals("editedtestytest", $comment->comment);
    }

    public function testCommentCount()
    {
        $this->assertEquals("3", self::$comments->commentCount());
    }

    public function testDeleteComment()
    {
        $comment = new Comment();
        $comment->setDb(self::$di->get("db"));
        $comment = $comment->find("author", "test");
        self::$comments->deleteComment($comment->id, self::$di->get("db"));
    }

    public function testCommentSection()
    {
        $url = self::$di->get("url")->create('post_comment');
        $del = self::$di->get("url")->create('delete_comment');
        $edit = self::$di->get("url")->create('preview');
        self::$comments->commentSection($url, $del, $edit, self::$session);
    }
}
