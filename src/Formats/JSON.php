<?php

namespace Nathanmac\Utilities\Responder\Formats;

use Nathanmac\Utilities\Responder\Exceptions\ResponderException;

/**
 * JSON Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class JSON implements FormatInterface
{
    /**
     * Generate Payload Data
     *
     * @param array  $payload
     * @param string $container
     *
     * @throws ResponderException
     *
     * @return string
     */
    public function generate($payload, $container = 'data')
    {
        if ($payload) {
            $prevHandler = set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
                throw new ResponderException('Failed To Generate JSON'); // @codeCoverageIgnore
            });

            $json = json_encode([$container => $payload]);
            if ( ! $json) {
                set_error_handler($prevHandler);  // @codeCoverageIgnore
                throw new ResponderException('Failed To Generate JSON');  // @codeCoverageIgnore
            }

            set_error_handler($prevHandler);

            return $json;
        }

        return '';
    }
}
