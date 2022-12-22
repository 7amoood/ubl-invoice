<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;
use DateTime;

class BillingReference implements XmlSerializable
{
    private $invoiceDocumentReferenceID;

    /**
     * @return String
     */
    public function getInvoiceDocumentReferenceID()
    {
        return $this->invoiceDocumentReferenceID;
    }

    /**
     * @param String $invoiceDocumentReferenceID
     * @return BillingReference
     */
    public function setInvoiceDocumentReferenceID($invoiceDocumentReferenceID): BillingReference
    {
        $this->invoiceDocumentReferenceID = $invoiceDocumentReferenceID;
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
        if ($this->invoiceDocumentReferenceID != null) {
            $writer->write([
                Schema::CAC . 'InvoiceDocumentReference' => [ 
                    Schema::CBC . 'ID' => $this->invoiceDocumentReferenceID
                ]
            ]);
        }
    }
}
