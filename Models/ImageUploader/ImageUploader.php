<?php

namespace Models\ImageUploader;

use Models\FileSystem\DownloadableEntity;
use Models\FileSystem\Exception\IOException;

interface ImageUploader
{
    /**
     * @param array $allowedDimensions
     */
    public function setAllowedDimensions(array $allowedDimensions): void;

    /**
     * @param array $allowedExtensions
     */
    public function setAllowedExtensions(array $allowedExtensions): void;

    /**
     * @param array $allowedSize
     */
    public function setAllowedSize(array $allowedSize): void;

    public function validateImage(): bool;

    public function getErrorCode(): int;

    public function setImageSource($path): void;

    /**
     * @return DownloadableEntity|null
     * @throws IOException
     */
    public function saveImage(): ?DownloadableEntity;
}