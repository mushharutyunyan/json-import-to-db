<?php

namespace App\Helpers;

class FilesHelper
{
    public static function getFileSize($url): int
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_exec($ch);
        $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $fileSize;
    }
}
