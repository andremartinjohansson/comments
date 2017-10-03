<?php

$comment = $di->get("commentsController")->get($_GET['id']);

if ($comment->author !== $di->get("session")->get("user")['name']) {
    if ($di->get("session")->get("user")['role'] !== "admin") {
        $di->get("response")->redirect("404");
    }
}

$text = $comment->comment;

?>

<h2 class="center">Edit Comment</h2>

    <form action="<?=$di->get("url")->create('edit_comment')?>" method="post">

    <input type="hidden" name="id" value="<?=$_GET['id']?>">

    <div class="compose-comment">
        <textarea class="comment-text-large" name="comment" required="required"><?=$text?></textarea>
    </div>

    <input class="comment-post" name="submit" type="submit" value="Submit">

</form>
