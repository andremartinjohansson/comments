<?php

namespace Anax\Comments;

use \Anax\Comments\Filter;

class Comments
{

    private $data = array();

    public function init($db)
    {
        $comment = new Comment();
        $comment->setDb($db);

        $this->data = array();

        $allComments = $comment->findAll();
        foreach ($allComments as $comment) {
            $input = array(
                'id' => $comment->id,
                'article' => $comment->article,
                'author' => $comment->author,
                'email' => $comment->email,
                'comment' => $comment->comment);

            array_push($this->data, $input);
        }
    }

    public function getComment($id, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $content = $comment->find("id", $id);

        return $content;
    }

    public function getAllComments()
    {
        return $this->data;
    }

    public function addComment($vars, $db, $user)
    {
        $input = array(
            'id' => ($this->commentCount() + 1),
            'article' => $vars['article'],
            'author' => $user["name"],
            'email' => $user["email"],
            'comment' => $vars['comment']);

        array_push($this->data, $input);

        $comment = new Comment();
        $comment->setDb($db);
        $comment->article = $input['article'];
        $comment->author = $user["name"];
        $comment->email = $user["email"];
        $comment->comment = $input['comment'];
        $comment->save();
    }

    public function deleteComment($id, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $comment = $comment->find("id", $id);
        $comment->delete();
    }

    public function editComment($id, $text, $db)
    {
        $comment = new Comment();
        $comment->setDb($db);
        $old = $comment->find("id", $id);
        $comment->article = $old->article;
        $comment->author = $old->author;
        $comment->email = $old->email;
        $comment->comment = $text;
        $comment->save();
    }

    public function commentCount()
    {
        return count($this->data);
    }

    public function commentSection($post, $del, $edt, $session)
    {
        $comments = $this->getAllComments();

        $htmlSection = "";

        $filter = new Filter();

        $user = $session->get("user");

        foreach ($comments as $comment) {
            $author = $comment['author'];
            $content = $filter->bbcode2html($comment['comment']);
            $emailHash = md5(strtolower(trim($comment['email'])));
            if ($user["name"] == $author) {
                $delete = "<p><a href='" . $del . "?id=" . $comment['id'] . "'>Ta bort</a></p>";
                $edit = "<p><a href='" . $edt . "?id=" . $comment['id'] . "'>Redigera</a></p>";
            } elseif ($user["role"] == "admin") {
                $delete = "<p><a href='" . $del . "?id=" . $comment['id'] . "'>Ta bort</a></p>";
                $edit = "<p><a href='" . $edt . "?id=" . $comment['id'] . "'>Redigera</a></p>";
            } else {
                $delete = "";
                $edit = "";
            }
            $htmlSection .=
                <<<EOD
                <div class="comment">
                <img class="avatar"
                src="https://www.gravatar.com/avatar/{$emailHash}?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png"
                alt="gravatar">
                <address class="vcard author">
                Av <em>{$author}</em>
                </address>

                <div class="entry-content">
                {$content}
                </div>
                <div class="comment-actions">
                {$edit}
                {$delete}
                </div>
                </article>
                </div>
EOD;
        }

        $htmlSection .=
            <<<EOD
            <div class="leave-comment">
            <h3>Skriv en kommentar</h3>
            <form action="{$post}" method="post">
            <input type="hidden" name="author" value="Anonymous">
            <input type="hidden" name="article" value="1">
            <div class="compose-comment">
            <textarea class="comment-text" name="comment" required="required"></textarea>
            </div>
            <input class="comment-post" name="submit" type="submit" value="Posta">
            </form>
            </div>
EOD;
        echo $htmlSection;
    }
}
