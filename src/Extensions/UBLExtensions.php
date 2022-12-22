<?php

namespace NumNum\UBL\Extensions;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use NumNum\UBL\Schema;

use InvalidArgumentException;

class UBLExtensions implements XmlSerializable
{
    private $extensions;

    /**
     * @param UBLExtension $ext
     * @return Invoice
     */
    public function addUBLExtension(UBLExtension $ext): UBLExtensions
    {
        $this->extensions[] = $ext;
        return $this;
    }

    /**
     * The validate function that is called during xml writing to valid the data of the object.
     *
     * @throws InvalidArgumentException An error with information about required data that is missing to write the XML
     * @return void
     */
    public function validate()
    {
        
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $this->validate();

        if($this->extensions !== null) {
            foreach ($this->extensions as $extension) {
                $writer->write([
                    Schema::EXT . 'Extension' => $extension
                ]);
            }
        }
    }
}
