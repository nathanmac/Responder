<?php namespace Nathanmac\Utilities\Responder\Formats;

/**
 * JSON Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class JSON implements FormatInterface {

    /**
     * Generate Payload Data
     *
     * @param array  $payload
     * @param string $container
     *
     * @return string
     */
    public function generate($payload, $container = 'data')
    {
        return json_encode(array($container => $payload));
    }

}
