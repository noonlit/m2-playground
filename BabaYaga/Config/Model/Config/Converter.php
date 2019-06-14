<?php

namespace BabaYaga\Config\Model\Config;

/**
 * Class Converter
 *
 * @package BabaYaga\Config\Model\Config
 */
class Converter implements \Magento\Framework\Config\ConverterInterface
{
    /**
     * Class responsible for converting the read XML into an array representation.
     *
     * @param \DOMDocument $source
     *
     * @return array
     */
    public function convert($source)
    {
        $output = [];
        if (!$source instanceof \DOMDocument) {
            return $output;
        }

        /** @var \DOMNodeList $sections */
        $main = $source->getElementsByTagName('covens');

        $data = [];
        /** @var \DOMElement $section */
        foreach ($main as $covensNode) {
            $area = $covensNode->getAttribute('area');

            /**
             * this is the content of a single coven node
             */
            $covenNodes = $covensNode->getElementsByTagName('coven');

            foreach ($covenNodes as $covenNode) {
                $names = $covenNode->getElementsByTagName('name');
                // improvement: how to read this as a single element?
                foreach ($names as $name) {
                    $data[$covenNode->localName]['name'] = $name->textContent;
                }


                $postcodes = $covenNode->getElementsByTagName('postcode');
                foreach ($postcodes as $code) {
                    $data[$covenNode->localName]['postcode'] = $code->textContent;
                }

                $output[$area][] = $data;
            }
        }

        return $output;
    }
}
