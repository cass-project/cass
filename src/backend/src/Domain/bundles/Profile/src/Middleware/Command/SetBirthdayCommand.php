<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\InvalidBirthdayException;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Request\SetBirthdayRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SetBirthdayCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $parameters = (new SetBirthdayRequest($request))->getParameters();

            $this->profileService->setBirthday($profileId, $parameters->getDate());

            $responseBuilder
                ->setStatusSuccess();
        }catch(InvalidBirthdayException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}