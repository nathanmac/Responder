<?php

namespace Nathanmac\Utilities\Responder\Tests;

use Nathanmac\Utilities\Responder\Formats\FormatInterface;

/**
 * Custom Formatter
 */
class CustomFormatter implements FormatInterface
{
    /**
     * Generate Payload Data
     *
     * @param string $payload
     *
     * @throws ResponderException
     * @return array
     *
     */
    public function generate($payload, $container = 'data')
    {
        $payload; // Raw payload data

        $output = var_export([$container => $payload], true); // Process raw payload data to array

        return $output; // return array parsed data
    }
}
