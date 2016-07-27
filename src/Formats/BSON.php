<?php

namespace Nathanmac\Utilities\Responder\Formats;

use Nathanmac\Utilities\Responder\Exceptions\ResponderException;

/**
 * BSON Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class BSON implements FormatInterface
{
    /**
     * Generate Payload Data
     *
     * @param array $payload
     * @param string $container
     *
     * @throws ResponderException
     *
     * @return string
     */
    public function generate($payload, $container = 'data')
    {
        $function      = null;
        $function_list = [
            'bson_encode',
            'MongoDB\BSON\fromPHP',
        ];

        foreach ($function_list as $bson_function) {
            if (function_exists($bson_function)) {
                $function = $bson_function;
            }
        }

        if (is_null($function)) {
            throw new ResponderException('Failed To Generate BSON - Supporting Library Not Available');  // @codeCoverageIgnore
        }

        if ($payload) {
            $prevHandler = set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
                throw new \Exception;  // @codeCoverageIgnore
            });

            try {
                $bson = $function([$container => $payload]);
                if ( ! $bson) {
                    throw new \Exception;  // @codeCoverageIgnore
                }
            } catch (\Exception $e) {
                set_error_handler($prevHandler);
                throw new ResponderException('Failed To Generate BSON');
            }

            set_error_handler($prevHandler);

            return $bson;
        }

        return '';
    }
}
