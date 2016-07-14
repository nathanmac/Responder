<?php

namespace Nathanmac\Utilities\Responder\Formats;

/**
 * Formatter Interface
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
interface FormatInterface
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
    public function generate($payload, $container = 'data');
}
