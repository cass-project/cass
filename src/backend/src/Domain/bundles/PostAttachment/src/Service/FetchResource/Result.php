<?php
namespace Domain\PostAttachment\Service\FetchResource;

final class Result
{
    /** @var string */
    private $origURL;

    /** @var string */
    private $content;

    /** @var string */
    private $contentType;
    
    public function __construct($origURL, $content, $contentType)
    {
        $this->origURL = $origURL;
        $this->content = $content;
        $this->contentType = $contentType;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }
}