<?php

namespace Anax\Comments;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

class CommentsController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function add()
    {
        $this->di->get("comments")->addComment($_POST, $this->di->get("db"), $this->di->get("session"));
        $this->di->get("response")->redirect("comments");
    }

    public function delete()
    {
        $this->di->get("comments")->deleteComment($_GET['id'], $this->di->get("db"));
        $this->di->get("response")->redirect("comments");
    }

    public function edit()
    {
        $this->di->get("comments")->editComment($_POST['id'], $_POST['comment'], $this->di->get("db"));
        $this->di->get("response")->redirect("comments");
    }

    public function get($id)
    {
        return $this->di->get("comments")->getComment($id, $this->di->get("db"));
    }

    public function addCommentSection()
    {
        $url = $this->di->get("url")->create('post_comment');
        $del = $this->di->get("url")->create('delete_comment');
        $edit = $this->di->get("url")->create('preview');
        $this->di->get("comments")->commentSection($url, $del, $edit);
    }

    public function renderMain()
    {
        $this->di->get("view")->add("comments");
        $this->di->get("pageRender")->renderPage([
            "title" => "Comments"
        ]);
    }

    public function renderEdit()
    {
        $this->di->get("view")->add("edit_comment");
        $this->di->get("pageRender")->renderPage([
            "title" => "Edit Comment"
        ]);
    }
}
