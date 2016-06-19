<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Middleware\Request\SetGenderRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class SetGenderCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
        $profileId = $request->getAttribute('profileId');
        $parameters = (new SetGenderRequest($request))->getParameters();

        $profile = $this->profileService->setGenderFromStringCode($profileId, $parameters->getGenderStringCode());

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'gender' => $profile->getGender()->toJSON()
            ])
            ->build();
    }
}