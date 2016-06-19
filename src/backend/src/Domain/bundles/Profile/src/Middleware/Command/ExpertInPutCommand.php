<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Middleware\Request\ExpertInRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInPutCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int)$request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $expertInRequest = new ExpertInRequest($request);
        $expertInParameters = $expertInRequest->getParameters();

        $this->profileService->setExpertsInParameters($profileId, $expertInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}