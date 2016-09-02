<?php
namespace CASS\Domain\Bundles\Attachment\Entity;

interface AttachmentOwner
{
    public function getOwnerCode(): string;

    public function getId(): string;
}