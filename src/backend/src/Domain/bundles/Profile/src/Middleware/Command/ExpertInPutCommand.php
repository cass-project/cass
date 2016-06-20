<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Request\ExpertInRequest;
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
            $this->profileService->setExpertsInThemes($profileId, array_unique(array_map('invtval', $themeIds)));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'expert_in_inds' => $profile->getExpertInIds()
                ]);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}