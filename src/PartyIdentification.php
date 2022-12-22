<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PartyIdentification implements XmlSerializable
{
    private $Id;
    private $schemeId;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->Id;
    }

    /**
     * @param string $Id
     * @return PartyIdentification
     */
    public function setId(?string $Id): PartyIdentification
    {
        $this->Id = $Id;
        return $this;
    }

    /**
     * @param string $schemeId
     * @return PartyIdentification
     */
    public function setSchemeId(?string $schemeId): PartyIdentification
    {
        $this->schemeId = $schemeId;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name' => Schema::CBC . 'ID',
            'value' => $this->Id,
            'attributes' => [
                'schemeID' => $this->schemeId ?? 'OTH'
            ]
        ]);
    }
}
