Responder
=========

[![Build Status](https://travis-ci.org/nathanmac/Responder.svg?branch=master)](https://travis-ci.org/nathanmac/Responder)
[![License](http://img.shields.io/packagist/l/nathanmac/Responder.svg)](https://github.com/nathanmac/Responder/blob/master/LICENSE.md)
[![Code Climate](https://codeclimate.com/github/nathanmac/Responder.png)](https://codeclimate.com/github/nathanmac/Responder)
[![Coverage Status](https://coveralls.io/repos/nathanmac/Responder/badge.png)](https://coveralls.io/r/nathanmac/Responder)
[![Latest Stable Version](https://poser.pugx.org/nathanmac/responder/v/stable.svg)](https://packagist.org/packages/nathanmac/responder)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/10f1505b-c48f-4020-a762-95d7685820be/mini.png)](https://insight.sensiolabs.com/projects/10f1505b-c48f-4020-a762-95d7685820be)

Simple PHP Responder Utility Library for API Development

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `Nathanmac/Responder`.

	"require": {
		"Nathanmac/Responder": "2.*"
	}

Next, update Composer from the Terminal:

    composer update

### Laravel Users

If you are a Laravel user, then there is a service provider that you can make use of to automatically prepare the bindings and such.

```php

// app/config/app.php

'providers' => [
    '...',
    'Nathanmac\Utilities\Responder\ResponderServiceProvider'
];
```

When this provider is booted, you'll have access to a helpful `Responder` facade, which you may use in your controllers.

```php
public function index()
{
    Responder::json($payload);         // Array > JSON
    Responder::xml($payload);          // Array > XML
    Responder::yaml($payload);         // Array > YAML
    Responder::querystr($payload);     // Array > Query String
    Responder::serialize($payload);    // Array > Serialized Object
    Responder::bson($payload);         // Array > BSON
    Responder::msgpack($payload);      // Array > MessagePack
}
```


#### Responder Functions
```php
$responder->json($payload);         // Array > JSON
$responder->xml($payload);          // Array > XML
$responder->yaml($payload);         // Array > YAML
$responder->querystr($payload);     // Array > Query String
$responder->serialize($payload);    // Array > Serialized Object
$responder->bson($payload);         // Array > BSON
$responder->msgpack($payload);      // Array > MessagePack
```

#### Respond with Automatic Detection
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

header("Content-Type: {$responder->getContentType()}");
print $responder->payload($body);
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

#### Respond with BSON
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

header('Content-Type: application/bson');
print $responder->bson($body);
```

#### Respond with MessagePack
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

header('Content-Type: application/x-msgpack');
print $responder->msgpack($body);
```

Custom Responders/Formatters
-------------------------

You can make your own custom responders/formatters by implementing [FormatInterface](https://github.com/nathanmac/Responder/blob/master/src/Formats/FormatInterface.php), the below example demostrates the use of a custom responder/formatter.

```php
use Nathanmac\Utilities\Responder\Formats\FormatInterface;

/**
 * Custom Formatter
 */

class CustomFormatter implements FormatInterface {
    /**
     * Generate Payload Data
     *
     * @param array $payload
     *
     * @return string
     *
     * @throws ResponderException
     */
    public function generate($payload)
    {
        $payload; // Raw payload array

        $output = // Process raw payload array to formatted data

        return $output; // return data string
    }
}
```

##### Using the CustomFormatter

```php
use Acme\Formatters\CustomFormatter;

$responder = new Responder();
$generated = $responder->generate(['raw' => 'payload', 'data'], new CustomFormatter());
```

##### Register the CustomFormatter

```php
use Acme\Formatters\CustomFormatter;

$responder = new Responder();
$responder->registerFormat('application/x-custom-format', 'Acme\Formatters\CustomFormatter');
$responder->payload('application/x-custom-format');
```

Testing
-------

To test the library itself, run the PHPUnit tests:

    phpunit tests/
