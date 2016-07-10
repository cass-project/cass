<?php
namespace Domain\OpenGraph\Service;

use Domain\OpenGraph\Exception\EmptyURLException;
use Domain\OpenGraph\Exception\InvalidURLException;
use Domain\OpenGraph\Exception\URLRestrictedException;
use Domain\OpenGraph\Parser\OpenGraphParser;

final class OpenGraphService
{
    /** @var OpenGraphParser */
    private $openGraphParser;

    public function __construct(OpenGraphParser $openGraphParser)
    {
        $this->openGraphParser = $openGraphParser;
    }

    public function getOPG(string $url): array
    {
        libxml_use_internal_errors(true);

        $source = $this->curl($url);
        $document = new \DOMDocument();
        $document->loadHTML($source);

        return $this->openGraphParser->parse($url, $document);
    }

    private function curl($url)
    {
        $this->validateURL($url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_UPLOAD, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        return curl_exec($ch);
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
            $_SERVER['SERVER_NAME']
        ];

        if(in_array($urlParts['host'], $restricted)) {
            throw new URLRestrictedException(sprintf('URL `%s` is restricted', $restricted));
        }
    }
}