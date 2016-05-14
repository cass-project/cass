<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class SwitchCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response {
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));
        $profile = $this->profileService->switchTo($this->currentAccountService->getCurrentAccount(), $profileId);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $profile->toJSON()
            ])
            ->build();
    }
}