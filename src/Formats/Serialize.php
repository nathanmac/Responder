<?php

namespace Nathanmac\Utilities\Responder\Formats;

use Nathanmac\Utilities\Responder\Exceptions\ResponderException;

/**
 * Serialize Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class Serialize implements FormatInterface
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
            try {
                return serialize([$container => $payload]);
            } catch (\Exception $ex) {
                throw new ResponderException('Failed To Generate Serialized Data');
            }
        }

        return '';
    }
}
