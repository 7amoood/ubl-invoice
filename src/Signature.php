<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use InvalidArgumentException;

class Signature implements XmlSerializable
{
    private $id;
    private $signatureMethod;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param String $id
     * @return Signature
     */
    public function setId(String $id): Signature
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return String
     */
    public function getSignatureMethod(): ?String
    {
        return $this->signatureMethod;
    }

    /**
     * @param String $endDate
     * @return Signature
     */
    public function setSignatureMethod(String $signatureMethod): Signature
    {
        $this->signatureMethod = $signatureMethod;
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
        if ($this->id === null) {
            throw new InvalidArgumentException('Missing ID');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $this->validate();

        $writer->write([
            Schema::CBC . 'ID' => $this->id,
            Schema::CBC . 'SignatureMethod' => $this->signatureMethod,
        ]);
    }
}
