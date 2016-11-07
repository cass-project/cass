<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Card;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Middleware\Command\Command;
use CASS\Domain\Bundles\Profile\Middleware\Request\Card\SetProfileCardRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class ImportProfileCardCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $this->validation->validateIsProfileOwnedByAccount($this->currentAccountService->getCurrentAccount(), $profile);

            $profileCard = $this->profileCardService->importProfileCard($profile, (new SetProfileCardRequest($request))->getParameters());

            $responseBuilder
                ->setJson([
                    'card' => $profileCard->toJSON(),
                ])
                ->setStatusSuccess();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}