<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Middleware\Request\ExpertInRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInPutCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $this->validation->validateIsProfileOwnedByAccount(
                $this->currentAccountService->getCurrentAccount(),
                $this->profileService->getProfileById($profileId)
            );

            $themeIds = (new ExpertInRequest($request))->getParameters()->getThemeIds();
            $this->profileService->setExpertsInThemes($profileId, array_unique(array_map('intval', $themeIds)));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'expert_in_ids' => $profile->getExpertInIds()
                ]);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}