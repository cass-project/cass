<?php
namespace Domain\Feedback\FeedbackType;

use Application\Util\JSONSerializable;

interface FeedbackType extends JSONSerializable
{
    public function getIntCode(): int;
    public function getStringCode(): string;
    public function getTitle(): string;
    public function getDescription(): string;
}