<?php

require "../vendor/autoload.php";

use Nathanmac\Utilities\Responder\Respoder;

$responder = new Responder();

$body = [
        'to'      => 'Jack Smith',
        'from'    => 'Jane Doe',
        'subject' => 'Hello World',
        'body'    => 'Hello, whats going on...'
];

header("Content-Type: {$responder->getContentType()}");
print $responder->payload($body);
