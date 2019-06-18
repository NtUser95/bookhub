<?php

namespace Models\FileSystem;

use Models\FileSystem\Exception\IOException;

class SimpleFileSystem implements FileSystem
{
    private $uploadPath = ROOT_PATH . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;

    /**
     * @param array $params
     * 1) fileId
     * @return DownloadableEntity|null
     * @throws IOException
     */
    public function getFile($params = []): ?DownloadableEntity
    {
        if (!isset($params['fileId']) || !$params['fileId']) {
            return null;
        }
        $fileDir = $this->uploadPath . $params['fileId'];
        if (!file_exists($fileDir)) {
            return null;
        } elseif (!is_readable($fileDir)) {
            throw new IOException($fileDir . ' isnt readable');
        }

        $internalPath = $fileDir;
        $externalPath = DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $params['fileId'];

        return new DownloadableEntity($params['fileId'], $externalPath, $internalPath);
    }

    public function fileExists($params = []): bool
    {
        if (!isset($params['fileId']) || !$params['fileId']) {
            return false;
        }

        $fileDir = $this->uploadPath . $params['fileId'];
        return file_exists($fileDir);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function removeFile($params = []): bool
    {
        if (!isset($params['fileId']) || !$params['fileId']) {
            return false;
        }
        $fileDir = $this->uploadPath . $params['fileId'];
        if (!file_exists($fileDir)) {
            return false;
        }
        return unlink($fileDir);
    }

    /**
     * @param array $params
     * 1) internalPath
     * @return DownloadableEntity
     * @throws IOException
     */
    public function uploadFile($params = []): DownloadableEntity
    {
        $sourceFilePath = $params['internalPath'];
        if (!is_readable($sourceFilePath)) {
            throw new IOException('file path:"' . $sourceFilePath . '" isnt readable');
        }
        $sourceFileExtension = Util::mime2ext(mime_content_type($sourceFilePath));
        $fileName = $this->_generateFilename($sourceFileExtension);
        $newFilePath = $this->uploadPath . $fileName;

        if (move_uploaded_file($sourceFilePath, $newFilePath)) {
            return $this->getFile([
                'fileId' => $fileName,
            ]);
        } else {
            throw new IOException('fail to save file path:"' . $newFilePath . '"');
        }
    }

    private function _generateFilename($extension): string
    {
        do {
            $filename = md5(mt_rand(0, 999999999999999)) . '.' . $extension;
        } while ($this->fileExists($filename));

        return $filename;
    }

    public function moveFile($params = []): bool
    {
        return false;
    }
}