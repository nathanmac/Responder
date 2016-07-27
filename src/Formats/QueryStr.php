<?php

namespace Nathanmac\Utilities\Responder\Formats;

/**
 * Query String Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class QueryStr implements FormatInterface
{
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
        if ($payload) {
            return http_build_query([$container => $payload]);
        }

        return '';
    }
}
