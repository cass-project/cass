<?php
namespace Domain\Profile\Middleware\Command;

use Application\Exception\PermissionsDeniedException;
use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Middleware\Request\EditPersonalRequest;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Psr\Http\Message\ServerRequestInterface;

class EditPersonalCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder) {
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));
        $profile = $this->profileService->getProfileById($profileId);

        if(!$this->currentAccountService->getCurrentAccount()->isYoursProfile($profile)) {
            throw new PermissionsDeniedException("You're not an owner of this profiles");
        }

        $request = new EditPersonalRequest($request);
        $params = $request->getParameters(); /** @var EditPersonalParameters $params */

        $this->profileService->updatePersonalData($profileId, $params);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}