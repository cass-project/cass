<?php
namespace Domain\Profile\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Request\SetGenderRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class SetGenderCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
        try {
            $gender = $this->profileService->setGender($request->getAttribute('profileId'), Gender::createFromStringCode(
                (new SetGenderRequest($request))->getParameters()->getGenderStringCode()
            ));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'gender' => $gender->toJSON()
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}