<?php
namespace CASS\Domain\Attachment\Entity;

interface AttachmentOwner
{
    public function getOwnerCode(): string;

    public function getId(): string;
}