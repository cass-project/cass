<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int) $request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $expertInParameters = explode(',', $request->getAttribute('theme_ids'));

        $this->profileService->deleteExpertsInParameters($profileId, $expertInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}