<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class XMLTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_xml_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];
        $expected = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<data>\n <status>123</status>\n <message>hello world</message>\n</data>\n";

        $responder = new Responder();
        $this->assertEquals($expected, $responder->xml($payload));
    }

    /** @test */
    public function parser_empty_xml_data()
    {
        $responder = new Responder();
        $this->assertEquals('', $responder->xml([]));
    }

    /** @test */
    public function throws_an_exception_when_parsed_xml_bad_data()
    {
        $responder = new Responder();
        $this->setExpectedException('Exception', 'Failed To Generate XML');
        $responder->xml(tmpfile());
    }

    /** @test */
    public function format_detection_xml()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/xml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\XML', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/xml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\XML', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
