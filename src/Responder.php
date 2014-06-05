<?php namespace Nathanmac\ResponderUtility;

use Symfony\Component\Yaml\Dumper;
use XMLWriter;

class Responder
{
    public function xml($data, $startElement = 'data', $xml_version = '1.0', $xml_encoding = 'UTF-8') {
        if (!is_array($data)) {
            return false; //return false error occurred
        }
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument($xml_version, $xml_encoding);
        $xml->startElement($startElement);

        $this->write($xml, $data);

        $xml->endElement(); //write end element
        //Return the XML results
        return $xml->outputMemory(true);
    }

    private function write(XMLWriter $xml, $data, $last_key = 'entity') {
        foreach ($data as $key => $value) {
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
                @$xml->writeAttribute(substr($key, 1), ($value==='') ? null: $value);
            }else {
                @$xml->writeElement($key, ($value==='') ? null: $value);
            }
        }
    }

    public function json($payload, $startElement = 'data') {
        return json_encode(array($startElement => $payload));
    }

    public function yaml($payload, $startElement = 'data') {
        $dumper = new Dumper();
        return $dumper->dump(array($startElement => $payload), 9999);
    }

    public function serialize($payload, $startElement = 'data') {
        return serialize(array($startElement => $payload));
    }

    public function querystr($payload, $startElement = 'data') {
        return http_build_query(array($startElement => $payload));
    }
}