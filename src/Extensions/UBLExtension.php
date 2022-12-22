<?php

namespace NumNum\UBL\Extensions;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use NumNum\UBL\Schema;

use InvalidArgumentException;

class UBLExtension implements XmlSerializable
{
    private $extensionURI;
    private $extensionContent;

    /**
     * @return mixed
     */
    public function getExtensionURI(): float
    {
        return $this->extensionURI;
    }

    /**
     * @param string $uri
     * @return UBLExtension
     */
    public function setExtensionURI(?string $uri): UBLExtension
    {
        $this->extensionURI = $uri;
        return $this;
    }

    public function setExtensionContent(?ExtensionContent $content): UBLExtension
    {
        $this->extensionContent = $content;
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
        if ($this->extensionURI === null) {
            throw new InvalidArgumentException('Missing extensionURI');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $this->validate();

        if($this->extensionURI) {
            $writer->write([
                Schema::EXT . 'ExtensionURI' => $this->extensionURI
            ]);
        }

        if($this->extensionContent) {
            $writer->write([
                Schema::EXT . 'ExtensionContent' => $this->extensionContent
            ]);
        }
    }
}
