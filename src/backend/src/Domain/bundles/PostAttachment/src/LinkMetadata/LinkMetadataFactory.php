<?php
namespace Domain\PostAttachment\LinkMetadata;

use Domain\OpenGraph\Parser\OpenGraphParser;
use Domain\PostAttachment\LinkMetadata\Types\ImageLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\PageLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\UnknownLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\YoutubeLinkMetadata;

final class LinkMetadataFactory
{
    /** @var OpenGraphParser */
    private $openGraphParser;

    public function __construct(OpenGraphParser $openGraphParser)
    {
        $this->openGraphParser = $openGraphParser;
    }

    public function createLinkMetadata(string $origURL, string $contentType, string $content): LinkMetadata
    {
        $resourceType = $this->getResourceType($origURL, $contentType);

        switch($resourceType) {
            default:
                throw new \Exception(sprintf('Unknown resource type `%s`', $resourceType));

            case YoutubeLinkMetadata::RESOURCE_TYPE:
                return new YoutubeLinkMetadata($origURL, $this->getOG($origURL, $content), $this->getYouTubeId($origURL));

            case PageLinkMetadata::RESOURCE_TYPE:
                return new PageLinkMetadata($origURL, $this->getOG($origURL, $content));

            case ImageLinkMetadata::RESOURCE_TYPE:
                return new ImageLinkMetadata($origURL);

            case UnknownLinkMetadata::RESOURCE_TYPE:
                return new UnknownLinkMetadata($origURL);
        }
    }

    private function getResourceType(string $origURL, string $contentType): string
    {
        if($this->testIsYouTube($origURL) && strlen($this->getYouTubeId($origURL))) {
            return YoutubeLinkMetadata::RESOURCE_TYPE;
        } else if($this->test(['html', 'xhtml'], $contentType)) {
            return PageLinkMetadata::RESOURCE_TYPE;
        } else if($this->test(['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/bmp'], $contentType)) {
            return ImageLinkMetadata::RESOURCE_TYPE;
        } else {
            return UnknownLinkMetadata::RESOURCE_TYPE;
        }
    }

    private function testIsYouTube(string $origURL)
    {
        return in_array(parse_url($origURL)['host'], [
            'youtube.com',
            'www.youtube.com'
        ]);
    }

    private function test(array $contentTypes, string $orig)
    {
        foreach($contentTypes as $contentType) {
            if(strpos($orig, $contentType) !== false) {
                return true;
            }
        }

        return false;
    }

    private function getOG(string $origURL, string $content): array
    {
        libxml_use_internal_errors(true);
        $document = new \DOMDocument($content);
        $document->loadHTML($content);
        libxml_clear_errors();

        if($document === false) {
            return [];
        } else {
            return $this->openGraphParser->parse($origURL, $document);
        }
    }

    private function getYouTubeId(string $origURL): string
    {
        parse_str(parse_url($origURL)['query'], $qp);

        return $qp['v'] ?? '';
    }
}