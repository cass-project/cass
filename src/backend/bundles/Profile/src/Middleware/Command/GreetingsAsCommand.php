<?php
namespace Profile\Middleware\Command;

use Profile\Entity\ProfileGreetings;
use Profile\Exception\UnknownGreetingsException;
use Profile\Middleware\Request\GreetingsFLRequest;
use Profile\Middleware\Request\GreetingsLFMRequest;
use Profile\Service\ProfileService;
use Psr\Http\Message\ServerRequestInterface;

class GreetingsAsCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $ps = $this->profileService;
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));

        switch($greetingsMethod = (string) strtolower($request->getAttribute('greetingsMethod'))) {
            default:
                throw new UnknownGreetingsException(sprintf('Unknown greetings method `%s`', $greetingsMethod));

            case ProfileGreetings::GREETINGS_FL:
                return $this->greetingsAsFL($request, $ps, $profileId);

            case ProfileGreetings::GREETINGS_LFM:
                return $this->greetingsAsLFM($request, $ps, $profileId);
        }
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
}