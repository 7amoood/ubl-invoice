<?php

namespace NumNum\UBL\Extensions;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use NumNum\UBL\Schema;

use InvalidArgumentException;

class ExtensionContent implements XmlSerializable
{
    private $signatureInformation;

    /**
     * @param string $uri
     * @return ExtensionContent
     */
    public function setSignatureInfo(?SignatureInformation $info): ExtensionContent
    {
        $this->signatureInformation = $info;
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
        /*if ($this->extensionURI === null) {
            throw new InvalidArgumentException('Missing extensionURI');
        }*/
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $this->validate();

        if($this->signatureInformation) {
            /*$signInfo = $writer->write([
                Schema::SAC.'SignatureInformation'=> $this->signatureInformation
            ]);*/

            /*$writer->write([
                [
                    'name' => Schema::SIG . 'UBLDocumentSignatures',
                    'value' => $signInfo,
                    'attributes' => [
                        'xmlns:sig' => 'urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2',
                        'xmlns:sac' => 'urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2',
                        'xmlns:sbc' => 'urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2',
                    ]
                ],
            ]);*/

            $writer->writeElement('{}'.Schema::SIG.'UBLDocumentSignatures', [
                    Schema::SAC.'SignatureInformation'=> $this->signatureInformation
                ]
            );
        }
    }
}
