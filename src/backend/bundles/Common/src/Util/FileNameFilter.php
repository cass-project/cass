<?php
namespace Common\Util;

class FileNameFilter
{
    public static function filter($fileName) {
        return preg_filter('/[^a-zA-Z0-9\_\.\-]/', '_', $fileName);
    }
}