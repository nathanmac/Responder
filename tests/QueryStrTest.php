<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class QueryStrTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_querystr_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];
        $expected = http_build_query(['data' => $payload]);

        $responder = new Responder();
        $this->assertEquals($expected, $responder->querystr($payload));
    }

    /** @test */
    public function parser_empty_querystr_data()
    {
        $responder = new Responder();
        $this->assertEquals('', $responder->querystr([]));
    }

    /** @test */
    public function format_detection_querystr()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/x-www-form-urlencoded";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\QueryStr', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
