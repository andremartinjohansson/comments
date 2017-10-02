<div class="thread-content">

    <h2>Vad tycker ni?</h2>

    <p>Mitt namn är André Johansson, men är mest känd som Andy bland mina kompisar. Jag är 23 år. Ursprungligen kommer jag från en liten stad i Skåne som jag älskar, men för att kunna plugga webbprogrammering i Karlskrona så har jag flyttat till Fridhemsgatan 24 i Karlshamn. Det är inte optimalt - tar mig cirka 40 minuter att ta mig till skolan. Som tur är har jag bil, men jag hoppas få en lägenhet närmre snart.</p>

    <p>Jag har tidigare jobbat en hel del med HTML, CSS och Javascript. Och dessutom lekt lite med PHP och design av webbsidor. Förutom kodningen så tycker jag det är kul att skapa och redigera bilder i Photoshop för webbplatsen man jobbar med. Photoshop har jag hållt på med sen jag var kanske 12 år bara för att det är kul. Webbprogrammering började jag inte med förrän sista året i gymnasiet. Det var någonting jag länge varit sugen på att testa, och fick möjlighet att välja det som kurs i tredje året. Efter det har jag inte kunnat sluta. ;)</p>

</div>

<?php

if ($di->get("session")->get("user") !== null) {
    $di->get("commentsController")->addCommentSection();
}

?>
