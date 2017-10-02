<?php

namespace Anax\Comments;

use \Anax\Comments\Comment;

class Comments
{

    private $data = array();

    // public function __construct()
    // {
    //     // session_start();
    //     //
    //     // if (isset($_SESSION['comments']) == true) {
    //     //     $this->data = $_SESSION['comments'];
    //     // }
    //
    // }

    public function init($db)
    {
        $comment = new Comment();
        $comment->setDb($db);

        $allComments = $comment->findAll();
        foreach ($allComments as $comment) {
            // var_dump($comment->author);
            $input = array(
                'id' => $comment->id,
                'article' => $comment->article,
                'author' => $comment->author,
                'email' => $comment->email,
                'comment' => $comment->comment);

            array_push($this->data, $input);
        }

        // var_dump($_SESSION);
    }

    public function getComment($id, $db)
    {
        // foreach ($this->data as $comment) {
        //     if ($comment['id'] == $id) {
        //         $content = $comment;
        //     } else {
        //         $content = "";
        //     }
        // }
        // var_dump($text);

        $comment = new Comment();
        $comment->setDb($db);
        $content = $comment->find("id", $id);

        return $content;
    }

    public function getAllComments()
    {
        // var_dump($this->data);
        return $this->data;
    }

    public function addComment($vars, $db, $session)
    {
        $user = $session->get("user");

        $input = array(
            'id' => $vars['id'],
            'article' => $vars['article'],
            'author' => $user["name"],
            'email' => $user["email"],
            'comment' => $vars['comment']);

        $input['id'] = count($this->data);

        array_push($this->data, $input);
        // $this->sync();

        $comment = new Comment();
        $comment->setDb($db);
        $comment->article = $input['article'];
        $comment->author = $user["name"];
        $comment->email = $user["email"];
        $comment->comment = $input['comment'];
        // var_dump($comment);
        // die();
        $comment->save();
    }

    public function deleteComment($id, $db)
    {
        // foreach ($this->data as $comment) {
        //     if ($comment['id'] == $id) {
        //         unset($this->data[$id]);
        //         $this->sync();
        //     }
        // }

        $comment = new Comment();
        $comment->setDb($db);
        $comment = $comment->find("id", $id);
        $comment->delete();
    }

    public function editComment($id, $text, $db)
    {
        // $this->data[$id]['comment'] = $text;
        // // var_dump($this->data[$id]);
        // $this->sync();

        $comment = new Comment();
        $comment->setDb($db);
        $old = $comment->find("id", $id);
        $comment->article = $old->article;
        $comment->author = $old->author;
        $comment->email = $old->email;
        $comment->comment = $text;
        $comment->save();
    }

    public function commentSection($post, $del, $edt)
    {
        $comments = $this->getAllComments();

        // var_dump($this->data);

        $htmlSection = "";

        foreach ($comments as $comment) {
            $author = $comment['author'];
            $content = $this->bbcode2html($comment['comment']);
            $emailHash = md5(strtolower(trim($comment['email'])));
            if ($_SESSION["user"]["name"] == $author) {
                $delete = "<p><a href='" . $del . "?id=" . $comment['id'] . "'>Ta bort</a></p>";
                $edit = "<p><a href='" . $edt . "?id=" . $comment['id'] . "'>Redigera</a></p>";
            } elseif ($_SESSION["user"]["role"] == "admin") {
                $delete = "<p><a href='" . $del . "?id=" . $comment['id'] . "'>Ta bort</a></p>";
                $edit = "<p><a href='" . $edt . "?id=" . $comment['id'] . "'>Redigera</a></p>";
            } else {
                $delete = "";
                $edit = "";
            }
            $htmlSection .=
                <<<EOD
                <div class="comment">
                <img class="avatar" src="https://www.gravatar.com/avatar/{$emailHash}?s=100&amp;d=http%3A%2F%2Fi.imgur.com%2FCrOKsOd.png" alt="gravatar">
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
            <div class="compose-comment">
            <textarea class="comment-text" name="comment" required="required"></textarea>
            </div>
            <input class="comment-post" name="submit" type="submit" value="Posta">
            </form>
            </div>
EOD;
        echo $htmlSection;
    }

    // private function sync()
    // {
    //     // $_SESSION['comments'] = $this->data;
    // }

    private function bbcode2html($bbtext)
    {

        $bbtags = array(
            '[heading1]' => '<h1>','[/heading1]' => '</h1>',
            '[heading2]' => '<h2>','[/heading2]' => '</h2>',
            '[heading3]' => '<h3>','[/heading3]' => '</h3>',
            '[heading4]' => '<h4>','[/heading4]' => '</h4>',
            '[h1]' => '<h1>','[/h1]' => '</h1>',
            '[h2]' => '<h2>','[/h2]' => '</h2>',
            '[h3]' => '<h3>','[/h3]' => '</h3>',
            '[h4]' => '<h4>','[/h4]' => '</h4>',

            '[paragraph]' => '<p>','[/paragraph]' => '</p>',
            '[para]' => '<p>','[/para]' => '</p>',
            '[p]' => '<p>','[/p]' => '</p>',
            '[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
            '[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
            '[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
            '[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',

            '[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
            '[italic]' => '<span style="font-weight:bold;">','[/italic]' => '</span>',
            '[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
            '[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
            '[i]' => '<span style="font-style:italic;">','[/i]' => '</span>',
            '[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
            '[break]' => '<br>',
            '[br]' => '<br>',
            '[newline]' => '<br>',
            '[nl]' => '<br>',

            '[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
            '[list]' => '<ul>','[/list]' => '</ul>',
            '[ul]' => '<ul>','[/ul]' => '</ul>',

            '[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
            '[ol]' => '<ol>','[/ol]' => '</ol>',
            '[list_item]' => '<li>','[/list_item]' => '</li>',
            '[li]' => '<li>','[/li]' => '</li>',

            '[*]' => '<li>','[/*]' => '</li>',
            '[code]' => '<code>','[/code]' => '</code>',
            '[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
            '[pre]' => '<pre>','[/pre]' => '</pre>',
        );

        $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

        $bbextended = array(
            "/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\">$1</a>",
            "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\">$2</a>",
            "/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
            "/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
            "/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
            "/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
            "/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
            "/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",
        );

        foreach ($bbextended as $match => $replacement) {
            $bbtext = preg_replace($match, $replacement, $bbtext);
        }

        return $bbtext;

    }
}
