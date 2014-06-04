<?php

require "../vendor/autoload.php";

use Nathanmac\ResponderUtility\Responder;
$responder = new Responder();

$body = array(
    'message' => array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
    )
);

header('Content-Type: application/xml; charset=utf-8');
print $responder->xml($body);
