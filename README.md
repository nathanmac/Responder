Responder
=========

[![Build Status](https://travis-ci.org/nathanmac/Responder.svg?branch=master)](https://travis-ci.org/nathanmac/Responder)
[![License](http://img.shields.io/packagist/l/nathanmac/Responder.svg)](https://github.com/nathanmac/Responder/blob/master/LICENSE.md)
[![Code Climate](https://codeclimate.com/github/nathanmac/Responder.png)](https://codeclimate.com/github/nathanmac/Responder)
[![Coverage Status](https://coveralls.io/repos/nathanmac/Responder/badge.png)](https://coveralls.io/r/nathanmac/Responder)
[![Release](http://img.shields.io/github/release/nathanmac/Responder.svg)](https://github.com/nathanmac/Responder/releases)

Simple PHP Responder Utility Library for API Development

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `Nathanmac/Responder`.

	"require": {
		"Nathanmac/Responder": "1.*"
	}

Next, update Composer from the Terminal:

    composer update

#### Responder Functions
```php
	$responder->json($payload);		    // JSON > Array
	$responder->xml($payload);		    // XML > Array
	$responder->yaml($payload);		    // YAML > Array
	$responder->querystr($payload);	    // Query String > Array
	$responder->serialize($payload);	// Serialized Object > Array
```

#### Respond with JSON
```php
$responder = new Responder();

$body = array(
    'message' => array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
    )
);

header('Content-Type: application/json');
print $responder->json($body);
```

#### Respond with XML
```php
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
```

#### Respond with Query String
```php
$responder = new Responder();

$body = array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
);

header('Content-Type: application/x-www-form-urlencoded');
print $responder->querystr($body);
```

#### Respond with Serialized Object
```php
$responder = new Responder();

$body = array(
    'message' => array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
    )
);

header('Content-Type: application/vnd.php.serialized');
print $responder->serialize($body);
```

#### Respond with YAML
```php
$responder = new Responder();

$body = array(
    'message' => array(
        'to' => 'Jack Smith',
        'from' => 'Jane Doe',
        'subject' => 'Hello World',
        'body' => 'Hello, whats going on...'
    )
);

header('Content-Type: application/x-yaml');
print $responder->yaml($body);
```

Testing
-------

To test the library itself, run the PHPUnit tests:

    phpunit tests/

