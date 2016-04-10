<?php
namespace Profile\Middleware\Command;

use Profile\Entity\ProfileGreetings;
use Profile\Exception\UnknownGreetingsException;
use Profile\Middleware\Request\GreetingsFLRequest;
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
                $greetingsRequest = new GreetingsFLRequest($request);
                $greetingsData = $greetingsRequest->getParameters();

                $firstName = $greetingsData['first_name'];
                $lastName = $greetingsData['last_name'];

                $ps->nameFL($profileId, $firstName, $lastName);

                break;
        }

        return true;
    }
}