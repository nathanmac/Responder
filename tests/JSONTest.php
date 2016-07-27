<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class JSONTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_json_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];
        $expected = json_encode(['data' => $payload]);

        $responder = new Responder();
        $this->assertEquals($expected, $responder->json($payload));
    }

    /** @test */
    public function parser_empty_json_data()
    {
        $responder = new Responder();
        $this->assertEquals('', $responder->json([]));
    }

    /** @test */
    public function throws_an_exception_when_parsed_json_bad_data()
    {
        $responder = new Responder();
        $this->setExpectedException('Exception', 'Failed To Generate JSON');
        $responder->json(tmpfile());
    }

    /** @test */
    public function format_detection_json()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/json";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "application/x-javascript";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/javascript";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/x-javascript";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/x-json";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
