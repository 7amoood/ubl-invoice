<?php

namespace NumNum\UBL;

use Exception;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use InvalidArgumentException;

class Attachment implements XmlSerializable
{
    private $filePath;
    private $externalReference;
    private $inlineContent;

    /**
     * @throws Exception exception when the mime type cannot be determined
     * @return string
     */
    public function getFileMimeType(): string
    {
        if (($mime_type = mime_content_type($this->filePath)) !== false) {
            return $mime_type;
        }

        throw new Exception('Could not determine mime_type of ' . $this->filePath);
    }

    /**
     * @return string
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return Attachment
     */
    public function setFilePath(string $filePath): Attachment
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getInlineContent(): ?string
    {
        return $this->inlineContent;
    }

    /**
     * @param string $inlineContent
     * @return Attachment
     */
    public function setInlineContent(string $inlineContent): Attachment
    {
        $this->inlineContent = $inlineContent;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }

    /**
     * @param string $externalReference
     * @return Attachment
     */
    public function setExternalReference(string $externalReference): Attachment
    {
        $this->externalReference = $externalReference;
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
        if (!$this->inlineContent) {
            if ($this->filePath === null) {
                throw new InvalidArgumentException('Missing filePath');
            }

            if (file_exists($this->filePath) === false) {
                throw new InvalidArgumentException('Attachment at filePath does not exist');
            }
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

        $fileName = '';
        $mimeType = '';
        $fileContents = '';

        if ($this->filePath) {
            $fileContents = base64_encode(file_get_contents($this->filePath));
            $mimeType = $this->getFileMimeType();
            $fileName = basename($this->filePath);
        } else if ($this->inlineContent) {
            $fileContents = $this->inlineContent;
            $mimeType = 'text/plain';
        }

        $writer->write([
            'name' => Schema::CBC . 'EmbeddedDocumentBinaryObject',
            'value' => $fileContents,
            'attributes' => [
                'mimeCode' => $mimeType,
                // 'filename' => $fileName
            ]
        ]);

        if ($this->externalReference !== null) {
            $writer->write(['externalReference' => $this->externalReference]);
        }
    }
}
