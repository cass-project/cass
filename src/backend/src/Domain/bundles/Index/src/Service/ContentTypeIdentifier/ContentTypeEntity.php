<?php
namespace Domain\IM\Service\ContentTypeIdentifier;

interface ContentTypeIdentifierEntity
{
    public function getContentType(): string;
}