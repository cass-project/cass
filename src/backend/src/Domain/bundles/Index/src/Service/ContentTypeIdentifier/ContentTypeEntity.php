<?php
namespace CASS\Domain\IM\Service\ContentTypeIdentifier;

interface ContentTypeIdentifierEntity
{
    public function getContentType(): string;
}