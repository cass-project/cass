<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Request\Params\SchemaParams;
use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Entity\Profile\Greetings\Greetings;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Request\GreetingsFLRequest;
use Domain\Profile\Middleware\Request\GreetingsLFMRequest;
use Domain\Profile\Middleware\Request\GreetingsNRequest;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class GreetingsAsCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
        try {
            $profileId = (int) $request->getAttribute('profileId');

            $this->validation->validateIsProfileOwnedByAccount(
                $this->currentAccountService->getCurrentAccount(),
                $this->profileService->getProfileById($profileId)
            );

            $method = $request->getAttribute('method');
            $parameters = (array)$this->getRequest($request, $method)->getParameters();

            $profile = $this->profileService->setGreetings($profileId, Greetings::createFromMethod(
                $method, $parameters
            ));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'greetings' => $profile->getGreetings()->toJSON()
                ]);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }

    private function getRequest(ServerRequestInterface $request, string $method): SchemaParams
    {
        switch (strtolower($method)) {
            default:
                throw new \Exception(sprintf('Unknown method `%s`', $method));

            case 'fl': return new GreetingsFLRequest($request);
            case 'lfm': return new GreetingsLFMRequest($request);
            case 'n': return new GreetingsNRequest($request);
        }
    }
}