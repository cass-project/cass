<?php
namespace Domain\IM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnreadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profile = $this->withProfileService->getProfile();
        $result = $this->imService->unreadMessages($profile->getId());

        $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'unread' => $result
            ]);

        return $responseBuilder->build();
    }
}