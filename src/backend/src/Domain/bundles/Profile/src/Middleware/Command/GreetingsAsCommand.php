<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Exception\UnknownGreetingsException;
use Domain\Profile\Middleware\Request\GreetingsFLRequest;
use Domain\Profile\Middleware\Request\GreetingsLFMRequest;
use Domain\Profile\Middleware\Request\GreetingsNRequest;
use Domain\Profile\Service\ProfileService;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class GreetingsAsCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
        $ps = $this->profileService;
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));

        switch($greetingsMethod = (string) strtolower($request->getAttribute('greetingsMethod'))) {
            default:
                new UnknownGreetingsException(sprintf('Unknown greetings method `%s`', $greetingsMethod));
                break;

            case ProfileGreetings::GREETINGS_FL:
                $this->greetingsAsFL($request, $ps, $profileId);
                break;

            case ProfileGreetings::GREETINGS_LFM:
                $this->greetingsAsLFM($request, $ps, $profileId);
                break;

            case ProfileGreetings::GREETINGS_N:
                $this->greetingsAsN($request, $ps, $profileId);
                break;
        }

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }

    private function greetingsAsFL(ServerRequestInterface $request, ProfileService $ps, int $profileId)
    {
        $greetingsRequest = new GreetingsFLRequest($request);
        $greetingsData = $greetingsRequest->getParameters();

        $firstName = $greetingsData['first_name'];
        $lastName = $greetingsData['last_name'];

        $ps->nameFL($profileId, $firstName, $lastName);

        return true;
    }

    private function greetingsAsLFM(ServerRequestInterface $request, ProfileService $ps, $profileId)
    {
        $greetingsRequest = new GreetingsLFMRequest($request);
        $greetingsData = $greetingsRequest->getParameters();

        $lastName = $greetingsData['last_name'];
        $firstName = $greetingsData['first_name'];
        $middleName = $greetingsData['middle_name'];

        $ps->nameLFM($profileId, $lastName, $firstName, $middleName);

        return true;
    }

    private function greetingsAsN(ServerRequestInterface $request, ProfileService $ps, $profileId)
    {
        $greetingsRequest = new GreetingsNRequest($request);
        $greetingsData = $greetingsRequest->getParameters();

        $nickName = $greetingsData['nickname'];

        $ps->nameN($profileId, $nickName);

        return true;
    }
}