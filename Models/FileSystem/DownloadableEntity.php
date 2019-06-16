<?php

namespace Models\FileSystem;

class DownloadableEntity
{
    /** @var string */
    private $externalPath;
    /** @var string */
    private $internalPath;

    public function __construct($externalPath, $internalPath)
    {
        $this->externalPath = $externalPath;
        $this->internalPath = $internalPath;
    }

    /**
     * @return string
     */
    public function getExternalPath(): string
    {
        return $this->externalPath;
    }

    /**
     * @return string
     */
    public function getInternalPath(): string
    {
        return $this->internalPath;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return filesize($this->internalPath);
    }

    /**
     * @return string MIME type
     */
    public function getFileType(): string
    {
        return mime_content_type($this->internalPath);
    }
}