<?php

namespace NumNum\UBL\Extensions;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use NumNum\UBL\Schema;

use InvalidArgumentException;

class SignatureInformation implements XmlSerializable
{
    private $id;
    private $referencedSignatureID;
    private $signature;

    /**
     * @param string $str
     * @return SignatureInformation
     */
    public function setId(?string $str): SignatureInformation
    {
        $this->id = $str;
        return $this;
    }

    /**
     * @param string $str
     * @return SignatureInformation
     */
    public function setReferencedSignatureID(?string $str): SignatureInformation
    {
        $this->referencedSignatureID = $str;
        return $this;
    }

    /**
     * @param string $str
     * @return SignatureInformation
     */
    public function setSignature(?string $str): SignatureInformation
    {
        $this->signature = $str;
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
        if ($this->referencedSignatureID === null) {
            throw new InvalidArgumentException('Missing referencedSignatureID');
        }
        if ($this->id === null) {
            throw new InvalidArgumentException('Missing id');
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

        $writer->write([
            Schema::CBC . 'ID' => $this->id
        ]);

        $writer->write([
            Schema::SBS . 'ReferencedSignatureID' => $this->referencedSignatureID
        ]);

        if($this->signature) {
            $writer->write([
                [
                    'name' => Schema::DS . 'Signature',
                    'value' => $this->signature,
                    'attributes' => [
                        'xmlns:ds'=>'http://www.w3.org/2000/09/xmldsig#',
                        'Id'=>'signature'
                    ],
                ]
            ]);
        }
    }
}
