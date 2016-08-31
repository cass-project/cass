<?php
namespace CASS\Application\Bootstrap;

use CASS\Application\Exception\EntityNotFoundException;
use CASS\Application\Exception\BadCommandCallException;
use CASS\Application\Exception\CommandNotFoundException;
use CASS\Application\Exception\PermissionsDeniedException;
use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use ZEA2\Platform\Bundles\REST\Request\Params\InvalidJSONSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Container\Exception\NotFoundException;

class FinalHandler
{
    public function __invoke(Request $request, Response $response, $error)
    {
        $responseBuilder = new GenericResponseBuilder($response);
        $responseBuilder->setStatusBadRequest();

        if($error === null) {
            $errorType = '404';

            $responseBuilder->setError($error);
            $responseBuilder
                ->setStatusNotFound()
                ->setError('404 Not Found')
            ;
        }else if($error instanceof  \Exception) {
            $errorType = get_class($error);

            $responseBuilder->setError($error);

            try {
                throw $error;
            } catch (EntityNotFoundException $e) {
                $responseBuilder->setStatusNotFound();
            } catch (InvalidJSONSchema $e) {
                $responseBuilder->setStatusBadRequest();
            } catch (CommandNotFoundException $e) {
                $responseBuilder->setStatusNotFound();
            } catch (BadCommandCallException $e) {
                $responseBuilder->setStatusBadRequest();
            } catch (NotFoundException $e) {
                $responseBuilder->setStatusNotFound();
            } catch (PermissionsDeniedException $e) {
                $responseBuilder->setStatusNotAllowed();
            } catch (\Exception $e) {
                $responseBuilder->setStatusInternalError();
            }
        }else if($error instanceof \Error) {
            throw $error;
        }else if(is_int($error)) {
            $errorType = "INT_CODE";
            $responseBuilder->setError(sprintf("ErrorCode: %d", $error));
        }else{
            throw new \Exception(sprintf('Unknown error: %s', get_class($error)));
        }

        return $responseBuilder->setJson([
            'error_type' => $errorType
        ])->build();
    }
}