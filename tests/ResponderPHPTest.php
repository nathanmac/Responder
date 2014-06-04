<?php

require dirname(__FILE__)."/../vendor/autoload.php";

use Nathanmac\ResponderUtility\Responder;

class ResponderPHPTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function responder_returns_xml_data()
    {
        $responder = new Responder();
$expected = '<?xml version="1.0" encoding="UTF-8"?>
<data>
 <status>123</status>
 <message>hello world</message>
</data>
';
        $this->assertEquals($responder->xml(array('status' => 123, 'message' => 'hello world')), $expected);
    }

    /** @test */
    public function responder_returns_json_data()
    {
        $responder = new Responder();
$expected = '{
    "data": {
        "status": 123,
        "message": "hello world"
    }
}';
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