<?php

require dirname(__FILE__)."/../vendor/autoload.php";

use Nathanmac\ResponderUtility\Responder;

class ResponderPHPTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function invalid_data_type_not_array()
    {
        $responder = new Responder();

        $this->assertFalse($responder->xml('string input'));
        $this->assertFalse($responder->xml(null));
        $this->assertFalse($responder->xml((object) array('message' => 'hello world')));
    }

    /** @test */
    public function responder_returns_xml_data()
    {
        $responder = new Responder();
$expected = '<?xml version="1.0" encoding="UTF-8"?>
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
        $this->assertEquals($responder->xml(array('@ref' => 987, 'status' => 123, 'message' => 'hello world', 'entities' => array('one', 'two'), 'input' => array('one', 'two'), 'values' => array('one', 'two'))), $expected);
    }

    /** @test */
    public function responder_returns_json_data()
    {
        $responder = new Responder();
        $expected = '{"data":{"status":123,"message":"hello world"}}';
        $this->assertEquals($responder->json(array('status' => 123, 'message' => 'hello world')), $expected);
    }

    /** @test */
    public function responder_returns_yaml_data()
    {
        $responder = new Responder();
$expected = "data:
    status: 123
    message: 'hello world'
";
        $this->assertEquals($responder->yaml(array('status' => 123, 'message' => 'hello world')), $expected);
    }

    /** @test */
    public function responder_returns_serialize_data()
    {
        $responder = new Responder();
        $expected = 'a:1:{s:4:"data";a:2:{s:6:"status";i:123;s:7:"message";s:11:"hello world";}}';
        $this->assertEquals($responder->serialize(array('status' => 123, 'message' => 'hello world')), $expected);
    }

    /** @test */
    public function responder_returns_query_string_data()
    {
        $responder = new Responder();
        $expected = 'data%5Bstatus%5D=123&data%5Bmessage%5D=hello+world';
        $this->assertEquals($responder->querystr(array('status' => 123, 'message' => 'hello world')), $expected);
    }




}