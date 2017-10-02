<?php
/**
 * Routes for comments.
 */
return [
    "routes" => [
        [
            "info" => "Comments page",
            "requestMethod" => null,
            "path" => "comments",
            "callable" => ["commentsController", "renderMain"],
        ],
        [
            "info" => "Comments edit page",
            "requestMethod" => null,
            "path" => "preview",
            "callable" => ["commentsController", "renderEdit"],
        ],
        [
            "info" => "Add comment",
            "requestMethod" => null,
            "path" => "post_comment",
            "callable" => ["commentsController", "add"],
        ],
        [
            "info" => "Delete comment",
            "requestMethod" => null,
            "path" => "delete_comment",
            "callable" => ["commentsController", "delete"],
        ],
        [
            "info" => "Edit comment",
            "requestMethod" => null,
            "path" => "edit_comment",
            "callable" => ["commentsController", "edit"],
        ],
    ]
];
