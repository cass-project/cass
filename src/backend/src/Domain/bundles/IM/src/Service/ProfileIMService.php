<?php
namespace Domain\ProfileIM\Service;

use Application\Exception\NotImplementedException;
use Domain\IM\Parameters\MessagesParameters;
use Domain\IM\Parameters\SendMessageParameters;

final class ProfileIMService
{
    public function sendMessage(SendMessageParameters $parameters)
    {
        throw new NotImplementedException;
    }

    public function getMessages(MessagesParameters $parameters)
    {
        throw new NotImplementedException;
    }

    public function unreadMessages(MessagesParameters $parameters)
    {
        throw new NotImplementedException;
    }
}