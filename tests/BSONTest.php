<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class BSONTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_bson_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];

        if (function_exists('bson_encode')) {
            $expected = bson_encode(['data' => $payload]);
        } elseif (function_exists('MongoDB\BSON\fromPHP')) {
            $expected = \MongoDB\BSON\fromPHP(['data' => $payload]);
        }

        if (function_exists('bson_encode') || function_exists('MongoDB\BSON\fromPHP')) {
            $responder = new Responder();
            $this->assertEquals($expected, $responder->bson($payload));
        }
    }

    /** @test */
    public function parser_empty_bson_data()
    {
        if (function_exists('bson_encode') || function_exists('MongoDB\BSON\fromPHP')) {
            $responder = new Responder();
            $this->assertEquals('', $responder->bson([]));
        }
    }

    /** @test */
    public function throw_an_exception_when_bson_library_not_loaded()
    {
        if ( ! (function_exists('bson_encode') || function_exists('MongoDB\BSON\fromPHP'))) {
            $this->setExpectedException('Exception', 'Failed To Generate BSON - Supporting Library Not Available');

            $responder = new Responder();
            $this->assertEquals('', $responder->bson([]));
        }
    }

    /** @test */
    public function throws_an_exception_when_parsed_bson_bad_data()
    {
        // Need to find something that will cause the bson_encode to fail...
        if (function_exists('bson_encode') || function_exists('MongoDB\BSON\fromPHP')) {
            $responder = new Responder();
            $this->setExpectedException('Exception', 'Failed To Generate BSON');
            $responder->bson([tmpfile(), function () {}], '');
        }
    }

    /** @test */
    public function format_detection_bson()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/bson";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\BSON', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
