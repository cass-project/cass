<?php
namespace Application\Bootstrap;

use Application\Exception\EntityNotFoundException;
use Application\Exception\BadCommandCallException;
use Application\Exception\CommandNotFoundException;
use Application\Exception\PermissionsDeniedException;
use Application\REST\Response\GenericResponseBuilder;
use Application\REST\Request\Params\InvalidJSONSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Container\Exception\NotFoundException;

class FinalHandler
{
    public function __invoke(Request $request, Response $response, $error)
    {
        $responseBuilder = new GenericResponseBuilder($response);
        $responseBuilder->setError($error);
        $responseBuilder->setStatusBadRequest();

        if($error === null) {
            $errorType = '404';

            $responseBuilder
                ->setStatusNotFound()
                ->setError('404 Not Found')
            ;
        }else if($error instanceof  \Exception){
            $errorType = get_class($error);

            try {
                throw $error;
            }catch(EntityNotFoundException $e){
                $responseBuilder->setStatusNotFound();
            }catch(InvalidJSONSchema $e){
                $responseBuilder->setStatusBadRequest();
            }catch(CommandNotFoundException $e) {
                $responseBuilder->setStatusNotFound();
            }catch(BadCommandCallException $e) {
                $responseBuilder->setStatusBadRequest();
            }catch(NotFoundException $e){
                $responseBuilder->setStatusNotFound();
            }catch(PermissionsDeniedException $e){
                $responseBuilder->setStatusNotAllowed();
            }
        }else{
            throw new \Exception('Unknown error');
        }

        return $responseBuilder->setJson([
            'error_type' => $errorType
        ])->build();
    }
}