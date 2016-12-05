<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Card;

use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Middleware\Command\Command;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class ExportProfileCardCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $accessLevel = $this->currentAccountService->isAvailable()
                ? $this->profileCardService->resoluteAccessLevel($profile, $this->currentAccountService->getCurrentAccount()->getCurrentProfile())
                : [ProfileCardAccess::ACCESS_PUBLIC];

            $this->profileCardService->exportProfileCard($profile, $accessLevel);

            $responseBuilder
                ->setJson([
                    'card' => $this->profileExtendedFormatter->formatOne($profile)['card'],
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