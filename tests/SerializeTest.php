<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class SerializeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_serialize_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];
        $expected = serialize(['data' => $payload]);

        $responder = new Responder();
        $this->assertEquals($expected, $responder->serialize($payload));
    }

    /** @test */
    public function parser_empty_serialize_data()
    {
        $responder = new Responder();
        $this->assertEquals('', $responder->serialize([]));
    }

    /** @test */
    public function throws_an_exception_when_parsed_serialize_bad_data()
    {
        // Need to find something that will cause the serialization to fail...
        $responder = new Responder();
        $this->setExpectedException('Exception', 'Failed To Generate Serialized Data');
        $responder->serialize(function () {});
    }

    /** @test */
    public function format_detection_serialize()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/vnd.php.serialized";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\Serialize', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
