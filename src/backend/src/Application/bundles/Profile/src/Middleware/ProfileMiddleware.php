<?php
namespace Application\Profile\Middleware;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Profile\Exception\NoThemesToMerge;
use Application\Profile\Exception\ProfileNotFoundException;
use Application\Profile\Exception\UnknownGreetingsException;
use Application\Profile\Middleware\Command\Command;
use Application\Profile\Service\ProfileService;
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