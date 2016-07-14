<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Responder;

class YAMLTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parser_validates_yaml_data()
    {
        $payload  = ['status' => 123, 'message' => 'hello world'];
        $expected = (new \Symfony\Component\Yaml\Dumper)->dump(['data' => $payload], 9999);

        $responder = new Responder();
        $this->assertEquals($expected, $responder->yaml($payload));
    }

    /** @test */
    public function parser_empty_yaml_data()
    {
        $responder = new Responder();
        $this->assertEquals('', $responder->yaml([]));
    }

    /** @test */
    public function throws_an_exception_when_parsed_yaml_bad_data()
    {
        $responder = new Responder();
        $this->setExpectedException('Exception', 'Failed To Generate YAML');
        $responder->yaml(tmpfile());
    }

    /** @test */
    public function format_detection_yaml()
    {
        $responder = new Responder();

        $_SERVER['HTTP_ACCEPT'] = "application/yaml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\YAML', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "application/x-yaml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\YAML', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/yaml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\YAML', $responder->getFormatClass());

        $_SERVER['HTTP_ACCEPT'] = "text/x-yaml";
        $this->assertEquals('Nathanmac\Utilities\Responder\Formats\YAML', $responder->getFormatClass());

        unset($_SERVER['HTTP_ACCEPT']);
    }
}
