<?php
namespace Domain\IM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\IM\Service\IMService\UnreadResult;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnreadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profile = $this->currentAccountService->getProfileWithId($request->getAttribute('targetProfileId'));
            $results = $this->imService->unreadMessages($profile->getId());

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'unread' => array_map(function(UnreadResult $result) {
                        return $result->toJSON();
                    }, $results)
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}