<?php

namespace Models\ImageUploader;

use App\App;
use Models\FileSystem\DownloadableEntity;
use Models\FileSystem\Exception\IOException;
use Models\FileSystem\Util;

class SimpleImageUploader implements ImageUploader
{
    //TODO Вынести это в классы выше
    private $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'gif',
    ];
    private $allowedDimensions = [
        'min_h' => 50,
        'max_h' => 1000,
        'min_w' => 50,
        'max_w' => 1000,
    ];
    private $allowedSize = [
        'min' => 10,
        'max' => 1024,
    ];
    /** @var string */
    private $imageInternalPath;
    private $errorCode = 0;


    public function setImageSource($path): void
    {
        $this->imageInternalPath = $path;
    }

    /**
     * @param array $allowedDimensions
     */
    public function setAllowedDimensions(array $allowedDimensions): void
    {
        $this->allowedDimensions = $allowedDimensions;
    }

    /**
     * @param array $allowedExtensions
     */
    public function setAllowedExtensions(array $allowedExtensions): void
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * @param array $allowedSize
     */
    public function setAllowedSize(array $allowedSize): void
    {
        $this->allowedSize = $allowedSize;
    }

    public function validateImage(): bool
    {
        if (!$this->imageInternalPath || !file_exists($this->imageInternalPath)) {
            $this->errorCode = ValidationStatuses::MISSING_IMAGE;
            return false;
        }

        $sourceFileExtension = Util::mime2ext(mime_content_type($this->imageInternalPath));
        if (!in_array($sourceFileExtension, $this->allowedExtensions)) {
            $this->errorCode = ValidationStatuses::INVALID_EXTENSION;
            return false;
        }

        $imageSize = filesize($this->imageInternalPath);//bytes
        if ($imageSize < $this->allowedSize['min'] || $imageSize > $this->allowedSize['max']) {
            $this->errorCode = ValidationStatuses::INVALID_WEIGHT;
            return false;
        }

        $imageDimension = getimagesize($this->imageInternalPath);// width height
        $imageHasInvalidWidth = $imageDimension[0] < $this->allowedDimensions['min_w'] || $imageDimension[0] > $this->allowedDimensions['max_w'];
        $imageHasInvalidHeight = $imageDimension[1] < $this->allowedDimensions['min_h'] || $imageDimension[1] > $this->allowedDimensions['max_h'];
        if ($imageHasInvalidWidth || $imageHasInvalidHeight) {
            $this->errorCode = ValidationStatuses::INVALID_DIMENSION;
            return false;
        }

        return true;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return DownloadableEntity|null
     * @throws IOException
     */
    public function saveImage(): ?DownloadableEntity
    {
        return App::$fileSystem->uploadFile([
            'internalPath' => $this->imageInternalPath,
        ]);
    }
}