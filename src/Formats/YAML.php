<?php namespace Nathanmac\Utilities\Responder\Formats;

/**
 * YAML Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class YAML implements FormatInterface {

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
        $dumper = new \Symfony\Component\Yaml\Dumper();
        return $dumper->dump(array($container => $payload), 9999);
    }

}
