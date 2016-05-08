<?php
namespace Domain\Profile\Middleware;

use Domain\Auth\Service\CurrentAccountService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Domain\Profile\Exception\NoThemesToMerge;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Exception\UnknownGreetingsException;
use Domain\Profile\Middleware\Command\Command;
use Domain\Profile\Service\ProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{
    /** @var ProfileService */
    private $profileService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(ProfileService $profileService, CurrentAccountService $currentAccountService)
    {
        $this->profileService = $profileService;
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $command = Command::factory($request, $this->profileService, $this->currentAccountService);
            $result = $command->run($request);

            if ($result === true) {
                $result = [];
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(UnknownGreetingsException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        } catch(NoThemesToMerge $e){
            $responseBuilder
              ->setStatusBadRequest()
              ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }
}