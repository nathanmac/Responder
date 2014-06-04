<?php

require "../vendor/autoload.php";

use Nathanmac\ResponderUtility\Responder;
$responder = new Responder();

$body = array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
);

header('Content-Type: application/x-www-form-urlencoded');
print $responder->querystr($body);
