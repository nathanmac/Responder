<?php

namespace Nathanmac\Utilities\Responder;

use Nathanmac\Utilities\Responder\Formats\BSON;
use Nathanmac\Utilities\Responder\Formats\FormatInterface;
use Nathanmac\Utilities\Responder\Formats\JSON;
use Nathanmac\Utilities\Responder\Formats\MSGPack;
use Nathanmac\Utilities\Responder\Formats\QueryStr;
use Nathanmac\Utilities\Responder\Formats\Serialize;
use Nathanmac\Utilities\Responder\Formats\XML;
use Nathanmac\Utilities\Responder\Formats\YAML;

/**
 * Responder Library, designed to generate various formats from a php array structure.
 *
 * @package    Nathanmac\Utilities\Responder
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class Responder
{
    /**
     * @var array Supported Formats
     */
    private $supported_formats =  [
      // XML
        'application/xml' => 'Nathanmac\Utilities\Responder\Formats\XML',
        'text/xml'        => 'Nathanmac\Utilities\Responder\Formats\XML',
        'xml'             => 'Nathanmac\Utilities\Responder\Formats\XML',
      // JSON
        'application/json'         => 'Nathanmac\Utilities\Responder\Formats\JSON',
        'application/x-javascript' => 'Nathanmac\Utilities\Responder\Formats\JSON',
        'text/javascript'          => 'Nathanmac\Utilities\Responder\Formats\JSON',
        'text/x-javascript'        => 'Nathanmac\Utilities\Responder\Formats\JSON',
        'text/x-json'              => 'Nathanmac\Utilities\Responder\Formats\JSON',
        'json'                     => 'Nathanmac\Utilities\Responder\Formats\JSON',
      // BSON
        'application/bson' => 'Nathanmac\Utilities\Responder\Formats\BSON',
        'bson'             => 'Nathanmac\Utilities\Responder\Formats\BSON',
      // YAML
        'text/yaml'          => 'Nathanmac\Utilities\Responder\Formats\YAML',
        'text/x-yaml'        => 'Nathanmac\Utilities\Responder\Formats\YAML',
        'application/yaml'   => 'Nathanmac\Utilities\Responder\Formats\YAML',
        'application/x-yaml' => 'Nathanmac\Utilities\Responder\Formats\YAML',
        'yaml'               => 'Nathanmac\Utilities\Responder\Formats\YAML',
      // MSGPACK
        'application/msgpack'   => 'Nathanmac\Utilities\Responder\Formats\MSGPack',
        'application/x-msgpack' => 'Nathanmac\Utilities\Responder\Formats\MSGPack',
        'msgpack'               => 'Nathanmac\Utilities\Responder\Formats\MSGPack',
      // MISC
        'application/vnd.php.serialized'    => 'Nathanmac\Utilities\Responder\Formats\Serialize',
        'serialize'                         => 'Nathanmac\Utilities\Responder\Formats\Serialize',
        'application/x-www-form-urlencoded' => 'Nathanmac\Utilities\Responder\Formats\QueryStr',
        'querystr'                          => 'Nathanmac\Utilities\Responder\Formats\QueryStr',
    ];

    /**
     * Format the payload array, autodetect format.
     *  Override the format by providing a content type.
     *
     * @param string $format
     * @param string $container
     *
     * @return array
     */
    public function payload($payload, $format = '', $container = 'data')
    {
        $class = $this->getFormatClass($format);
        return $this->generate($payload, new $class, $container);
    }

    /**
     * Autodetect the payload data type using content-type value.
     *
     * @param string $format
     *
     * @return string Return the formatter class name.
     */
    public function getFormatClass($format = '')
    {
        return $this->supported_formats[$this->getContentType($format)];
    }

    public function getContentType($format = '')
    {
        if (empty($format) && isset($_SERVER['ACCEPT'])) {
            $format = $_SERVER['ACCEPT'];
        }

        if (empty($format) && isset($_SERVER['HTTP_ACCEPT'])) {
            $format = $_SERVER['HTTP_ACCEPT'];
        }

        foreach (explode(';', $format) as $type) {
            $type = strtolower(trim($type));
            if (isset($this->supported_formats[$type])) {
                return $type;
            }
        }

        return 'application/json';
    }

    /**
     * Responder payload string using given formatter.
     *
     * @param array $payload
     * @param FormatInterface $format
     * @param string $container
     *
     * @return string
     */
    public function generate($payload, FormatInterface $format, $container = 'data')
    {
        return $format->generate($payload, $container);
    }

    /* ------------ Format Registration Methods ------------ */

    /**
     * Register Format Class.
     *
     * @param $format
     * @param $class
     *
     * @throws InvalidArgumentException
     *
     * @return self
     */
    public function registerFormat($format, $class)
    {
        if ( ! class_exists($class)) {
            throw new \InvalidArgumentException("Responder formatter class {$class} not found.");
        }
        if ( ! is_a($class, 'Nathanmac\Utilities\Responder\Formats\FormatInterface', true)) {
            throw new \InvalidArgumentException('Responder formatters must implement the Nathanmac\Utilities\Responder\Formats\FormatInterface interface.');
        }

        $this->supported_formats[$format] = $class;

        return $this;
    }

    /* ------------ Helper Methods ------------ */

    /**
     * XML Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function xml($payload, $container = 'data')
    {
        return $this->generate($payload, new XML(), $container);
    }

    /**
     * JSON Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function json($payload, $container = 'data')
    {
        return $this->generate($payload, new JSON(), $container);
    }

    /**
     * BSON Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function bson($payload, $container = 'data')
    {
        return $this->generate($payload, new BSON(), $container);
    }

    /**
     * MSGPack Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function msgpack($payload, $container = 'data')
    {
        return $this->generate($payload, new MSGPack(), $container);
    }

    /**
     * YAML Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function yaml($payload, $container = 'data')
    {
        return $this->generate($payload, new YAML(), $container);
    }

    /**
     * Serialize Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function serialize($payload, $container = 'data')
    {
        return $this->generate($payload, new Serialize(), $container);
    }

    /**
     * Query String Responder, helper function.
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function querystr($payload, $container = 'data')
    {
        return $this->generate($payload, new QueryStr(), $container);
    }
}
