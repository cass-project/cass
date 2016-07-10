<?php
namespace Domain\PostAttachment\Service;

use Domain\PostAttachment\Exception\EmptyURLException;
use Domain\PostAttachment\Exception\InvalidURLException;
use Domain\PostAttachment\Exception\NotFoundException;
use Domain\PostAttachment\Exception\URLRestrictedException;
use Domain\PostAttachment\Service\FetchResource\Result;

class FetchResourceService
{
    public function fetchResource(string $url): Result
    {
        list($ch, $result) = $this->curl($url);

        if($result === false) {
            throw new NotFoundException('Page not found');
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($result, $header_size);

        return new Result($url, $body, curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
    }

    private function curl($url)
    {
        $this->validateURL($url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_UPLOAD, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $result = curl_exec($ch);

        return [$ch, $result];
    }

    private function validateURL($url)
    {
        if(!strlen($url)) {
            throw new EmptyURLException("URL is empty");
        }

        $urlParts = parse_url($url);

        if(!$urlParts) {
            throw new InvalidURLException(sprintf('URL `%s` cannot be parsed', $url));
        }

        $restricted = [
            '127.0.0.1',
            '0.0.0.0',
            '255.255.255.0',
            '255.255.255.252',
            'localhost',
            $_SERVER['SERVER_NAME']
        ];

        if(in_array($urlParts['host'], $restricted)) {
            throw new URLRestrictedException(sprintf('URL `%s` is restricted', $restricted));
        }
    }
}