<?php
<?php
/**
 * Configuration file for routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            "mount" => null,
            "file" => __DIR__ . "/route/comments.php",
        ],
    ],

];
