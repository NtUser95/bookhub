<?php

namespace Models\FileSystem;

use Models\FileSystem\Exception\IOException;

interface FileSystem
{
    /**
     * @param array $params
     * @return DownloadableEntity|null
     */
    function getFile($params = []): ?DownloadableEntity;

    /**
     * @param array $params
     * @throws UploadException
     * @return DownloadableEntity
     */
    function uploadFile($params = []): DownloadableEntity;

    function fileExists($params = []): bool;

    function removeFile($params = []): bool;

    /**
     * @param array $params
     * 1) fileId
     * 2) moveInPath - пункт назначения
     * @return bool
     * @throws IOException
     */
    function moveFile($params = []): bool;
}