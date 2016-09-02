<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetBySIDCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $responseBuilder
                ->setJson([
                    'entity' => $this->profileExtendedFormatter->format(
                        $this->profileService->getProfileBySID($request->getAttribute('sid'))
                    )
                ])
                ->setStatusSuccess();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }
        
        return $responseBuilder->build();
    }
}