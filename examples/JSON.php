<?php

require "../vendor/autoload.php";

use Nathanmac\Utilities\Responder\Responder;

$responder = new Responder();

$body = [
    'message' => [
        'to'      => 'Jack Smith',
        'from'    => 'Jane Doe',
        'subject' => 'Hello World',
        'body'    => 'Hello, whats going on...'
    ]
];

header('Content-Type: application/json');
print $responder->json($body);
