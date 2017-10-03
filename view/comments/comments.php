<div class="thread-content">

    <h2>Prototyp av kommentarssystem</h2>

    <p>Här kan vi se att kommentarssystemet funkar när en användare är inloggad.</p>

</div>

<?php

if ($di->get("session")->get("user") !== null) {
    $di->get("commentsController")->addCommentSection();
}

?>
