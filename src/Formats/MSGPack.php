<?php

namespace Nathanmac\Utilities\Responder\Formats;

use Nathanmac\Utilities\Responder\Exceptions\ResponderException;

/**
 * MSGPack Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <hola@nathanmac.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class MSGPack implements FormatInterface
{
    /**
     * Generate Payload Data
     *
     * @param string $payload
     * @param string $container
     *
     * @throws ResponderException
     *
     * @return array
     */
    public function generate($payload, $container = 'data')
    {
        if (function_exists('msgpack_pack')) {
            if ($payload) {
                $prevHandler = set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
                    throw new ResponderException('Failed To Generate MSGPack');  // @codeCoverageIgnore
                });

                $msg = msgpack_pack([$container => $payload]);
                if ( ! $msg) {
                    set_error_handler($prevHandler);  // @codeCoverageIgnore
                    throw new ResponderException('Failed To Generate MSGPack');  // @codeCoverageIgnore
                }

                set_error_handler($prevHandler);

                return $msg;
            }
            return '';
        }

        throw new ResponderException('Failed To Generate MSGPack - Supporting Library Not Available');  // @codeCoverageIgnore
    }
}
