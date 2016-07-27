<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class MSGPackTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_msgpack_data()
    {
        if (function_exists('msgpack_pack')) {
            $payload  = ['status' => 123, 'message' => 'hello world'];
            $expected = msgpack_pack(['data' => $payload]);

            $responder = new Responder();
            $this->assertEquals($expected, $responder->msgpack($payload));
        }
    }

    /** @test */
    public function parser_empty_msgpack_data()
    {
        if (function_exists('msgpack_pack')) {
            $responder = new Responder();
            $this->assertEquals('', $responder->msgpack([]));
        }
    }

    /** @test */
    public function throw_an_exception_when_msgpack_library_not_loaded()
    {
        if ( ! function_exists('msgpack_pack')) {
            $this->setExpectedException('Exception', 'Failed To Generate MSGPack - Supporting Library Not Available');

            $responder = new Responder();
            $this->assertEquals('', $responder->msgpack([]));
        }
    }

    /** @test */
    public function throws_an_exception_when_parsed_msgpack_bad_data()
    {
        if (function_exists('msgpack_pack')) {
            $responder = new Responder();
            $this->setExpectedException('Exception', 'Failed To Generate MSGPack');
            $responder->msgpack(tmpfile());
        }
    }

    /** @test */
    public function format_detection_msgpack()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/msgpack";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\MSGPack', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "application/x-msgpack";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\MSGPack', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
