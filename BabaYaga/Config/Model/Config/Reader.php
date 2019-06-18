<?php

namespace BabaYaga\Config\Model\Config;

/**
 * Class Reader
 *
 * The class the docs refer to as the loader - see https://devdocs.magento.com/guides/v2.3/config-guide/config/config-create.html
 *
 * @package BabaYaga\Config\Model\Config
 */
class Reader extends \Magento\Framework\Config\Reader\Filesystem
{
    /**
     * Check the xsd. All covens are identified by an area attribute.
     *
     * @var array
     */
    protected $_idAttributes = [
        '/covens' => 'area',
    ];

    /**
     * Reader constructor.
     *
     * @param \Magento\Framework\Config\FileResolverInterface    $fileResolver
     * @param Converter                                          $converter
     * @param SchemaLocator                                      $schemaLocator
     * @param \Magento\Framework\Config\ValidationStateInterface $validationState
     * @param string                                             $fileName
     * @param array                                              $idAttributes
     * @param string                                             $domDocumentClass
     * @param string                                             $defaultScope
     */
    public function __construct(
        \Magento\Framework\Config\FileResolverInterface $fileResolver,
        Converter $converter,
        SchemaLocator $schemaLocator,
        \Magento\Framework\Config\ValidationStateInterface $validationState,
        $fileName = 'covens.xml',
        $idAttributes = [],
        $domDocumentClass = \Magento\Framework\Config\Dom::class,
        $defaultScope = 'global'
    ) {
        parent::__construct(
            $fileResolver,
            $converter,
            $schemaLocator,
            $validationState,
            $fileName,
            $idAttributes,
            $domDocumentClass,
            $defaultScope
        );
    }
}
