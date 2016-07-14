<?php

namespace Nathanmac\Utilities\Responder\Formats;

use Nathanmac\Utilities\Responder\Exceptions\ResponderException;
use Symfony\Component\Yaml\Yaml as SFYaml;

/**
 * YAML Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class YAML implements FormatInterface
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
                $flags = (defined('Symfony\Component\Yaml\Yaml::DUMP_OBJECT_AS_MAP')) ? (SFYaml::DUMP_OBJECT_AS_MAP | SFYaml::DUMP_EXCEPTION_ON_INVALID_TYPE) : true;
                return SFYaml::dump([$container => $payload], 9999, 4, $flags);
            } catch (\Exception $ex) {
                throw new ResponderException('Failed To Generate YAML');
            }
        }

        return '';
    }
}
