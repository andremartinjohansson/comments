<?php

namespace Anax\Comments;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

class CommentsController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $db;

    public function init($database)
    {
        $this->db = $database;
    }

    public function add()
    {
        $user = $this->di->get("session")->get("user");
        $this->di->get("comments")->addComment($_POST, $this->db, $user);
        $this->di->get("response")->redirect("comments");
    }

    public function delete()
    {
        $this->di->get("comments")->deleteComment($_GET['id'], $this->db);
        $this->di->get("response")->redirect("comments");
    }

    public function edit()
    {
        $this->di->get("comments")->editComment($_POST['id'], $_POST['comment'], $this->db);
        $this->di->get("response")->redirect("comments");
    }

    public function get($id)
    {
        return $this->di->get("comments")->getComment($id, $this->db);
    }

    public function addCommentSection()
    {
        $url = $this->di->get("url")->create('post_comment');
        $del = $this->di->get("url")->create('delete_comment');
        $edit = $this->di->get("url")->create('preview');
        $this->di->get("comments")->commentSection($url, $del, $edit, $this->di->get("session"));
    }

    public function renderMain()
    {
        $this->di->get("view")->add("comments/comments");
        $this->di->get("pageRender")->renderPage([
            "title" => "Comments"
        ]);
    }

    public function renderEdit()
    {
        $this->di->get("view")->add("comments/edit_comment");
        $this->di->get("pageRender")->renderPage([
            "title" => "Edit Comment"
        ]);
    }
}
