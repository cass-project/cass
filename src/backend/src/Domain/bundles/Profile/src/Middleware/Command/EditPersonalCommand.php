<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Middleware\Request\EditPersonalRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class EditPersonalCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');

        $this->validation->validateIsProfileOwnedByAccount(
            $this->currentAccountService->getCurrentAccount(),
            $this->profileService->getProfileById($profileId)
        );

        $request = new EditPersonalRequest($request);
        $params = $request->getParameters();

        $profile = $this->profileService->updatePersonalData($profileId, $params);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $profile->toJSON()
            ])
            ->build();
    }
}