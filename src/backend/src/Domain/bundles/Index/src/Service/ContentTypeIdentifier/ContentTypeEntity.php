<?php
namespace CASS\Domain\Bundles\IM\Service\ContentTypeIdentifier;

interface ContentTypeIdentifierEntity
{
    public function getContentType(): string;
}