<?php namespace Nathanmac\Utilities\Responder\Formats;

use XMLWriter;

/**
 * XML Formatter
 *
 * @package    Nathanmac\Utilities\Responder\Formats
 * @author     Nathan Macnamara <nathan.macnamara@outlook.com>
 * @license    https://github.com/nathanmac/Responder/blob/master/LICENSE.md  MIT
 */
class XML implements FormatInterface {

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
        if (!is_array($payload)) {
            return false; //return false error occurred
        }
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement($container);

        $this->write($xml, $payload);

        $xml->endElement(); //write end element
        //Return the XML results
        return $xml->outputMemory(true);
    }

    private function write(XMLWriter $xml, $payload, $last_key = 'entity') {
        foreach ($payload as $key => $value) {
            if (is_numeric($key)) {
                if (substr($last_key, -3) == 'ies') {
                    $key = substr($last_key, 0, -3) . 'y';
                } else if (substr($last_key, -1) == 's') {
                    $key = substr($last_key, 0, -1);
                } else {
                    $key = $last_key;
                }
            }

            if (is_array($value)) {
                $xml->startElement($key);
                $this->write($xml, $value, $key);
                $xml->endElement();
                continue;
            }
            if ($key[0]=='@') {
                $xml->writeAttribute(substr($key, 1), ($value==='') ? null: $value);
            }else {
                $xml->writeElement($key, ($value==='') ? null: $value);
            }
        }
    }

}
