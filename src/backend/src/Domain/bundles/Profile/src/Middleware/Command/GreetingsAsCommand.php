<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings\Greetings;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Middleware\Request\GreetingsFLRequest;
use CASS\Domain\Bundles\Profile\Middleware\Request\GreetingsLFMRequest;
use CASS\Domain\Bundles\Profile\Middleware\Request\GreetingsNRequest;
use Psr\Http\Message\ResponseInterface;

final class GreetingsAsCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
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