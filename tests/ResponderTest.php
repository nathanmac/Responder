<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class ResponderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function invalid_data_type_not_array()
    {
        $responder = new Responder();

        $this->setExpectedException('Exception', 'Failed To Generate XML - Payload not an array');
        $this->assertFalse($responder->xml('string input'));
        $this->assertFalse($responder->xml(null));
        $this->assertFalse($responder->xml((object) ['message' => 'hello world']));
    }

    /** @test */
    public function responder_returns_xml_data()
    {
        $responder = new Responder();
        $expected  = '<?xml version="1.0" encoding="UTF-8"?>
<data ref="987">
 <status>123</status>
 <message>hello world</message>
 <entities>
  <entity>one</entity>
  <entity>two</entity>
 </entities>
 <input>
  <input>one</input>
  <input>two</input>
 </input>
 <values>
  <value>one</value>
  <value>two</value>
 </values>
</data>
';
        $this->assertEquals($responder->xml(['@ref' => 987, 'status' => 123, 'message' => 'hello world', 'entities' => ['one', 'two'], 'input' => ['one', 'two'], 'values' => ['one', 'two']]), $expected);
    }

    /** @test */
    public function responder_returns_json_data()
    {
        $responder = new Responder();
        $expected  = '{"data":{"status":123,"message":"hello world"}}';
        $this->assertEquals($responder->json(['status' => 123, 'message' => 'hello world']), $expected);
    }

    /** @test */
    public function responder_returns_yaml_data()
    {
        $responder = new Responder();
        $expected  = "data:
    status: 123
    message: 'hello world'
";
        $this->assertEquals($responder->yaml(['status' => 123, 'message' => 'hello world']), $expected);
    }

    /** @test */
    public function responder_returns_serialize_data()
    {
        $responder = new Responder();
        $expected  = 'a:1:{s:4:"data";a:2:{s:6:"status";i:123;s:7:"message";s:11:"hello world";}}';
        $this->assertEquals($responder->serialize(['status' => 123, 'message' => 'hello world']), $expected);
    }

    /** @test */
    public function responder_returns_query_string_data()
    {
        $responder = new Responder();
        $expected  = 'data%5Bstatus%5D=123&data%5Bmessage%5D=hello+world';
        $this->assertEquals($responder->querystr(['status' => 123, 'message' => 'hello world']), $expected);
    }

    /** @test */
    public function format_detection_defaults_to_json()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "somerandomstuff";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $_SERVER['ACCEPT'] = "somerandomstuff";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        unset($_SERVER['ACCEPT'], $_SERVER['HTTP_ACCEPT']);
    }

    /** @test */
    public function responder_returns_data_with_payload_method()
    {
        $responder = new Responder();
        $expected  = '{"data":{"status":123,"message":"hello world"}}';
        $this->assertEquals($responder->payload(['status' => 123, 'message' => 'hello world']), $expected);
    }

    /** @test */
    public function can_register_format_classes()
    {
        // For some reason this won't autoload...
        require_once(__DIR__ . '/CustomFormatter.php');

        $responder = new Responder();

        $_SERVER['ACCEPT'] = "application/x-custom-format";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\JSON', $responder->getFormatClass());

        $responder->registerFormat('application/x-custom-format', 'Nathanmac\Utilities\Responder\Tests\CustomFormatter');
        $this->assertEquals('Nathanmac\Utilities\Responder\Tests\CustomFormatter', $responder->getFormatClass());

        unset($_SERVER['ACCEPT']);
    }
}
