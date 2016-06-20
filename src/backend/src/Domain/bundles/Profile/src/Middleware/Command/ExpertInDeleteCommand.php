<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInDeleteCommand extends Command
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

            $themeIds = array_map('intval', explode(',', $request->getAttribute('theme_ids')));

            $this->profileService->setExpertsInThemes($profileId, array_filter($profile->getExpertInIds(), function (int $themeId) use ($themeIds) {
                return !in_array($themeId, $themeIds);
            }));

            $responseBuilder->setStatusSuccess()->setJson([
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