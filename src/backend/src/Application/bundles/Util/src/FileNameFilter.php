<?php
namespace Application\Util;

class FileNameFilter
{
    public static function filter($fileName) {
        return preg_replace('/[^a-zA-Z0-9\_\.\-]/', '_', $fileName);
    }
}