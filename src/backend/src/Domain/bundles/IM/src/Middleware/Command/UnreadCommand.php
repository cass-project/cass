<?php
namespace CASS\Domain\Bundles\IM\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\IM\Service\IMService\UnreadResult;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnreadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profile = $this->currentAccountService->getCurrentAccount()->getProfileWithId($request->getAttribute('targetProfileId'));
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