<?php namespace Nathanmac\Utilities\Responder;

use Nathanmac\Utilities\Responder\Formats\FormatInterface;
use Nathanmac\Utilities\Responder\Formats\JSON;
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
     * Responder payload string using given formatter.
     *
     * @param array $payload
     * @param FormatInterface $format
     * @param string $container
     *
     * @return string
     */
    public function generate($payload, FormatInterface $format, $container = 'data') {
        return $format->generate($payload, $container);
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
