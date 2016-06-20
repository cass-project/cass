<?php
namespace Application\REST\Response;

use Psr\Http\Message\ResponseInterface;

class ResponseBuilder
{
    const CODE_SUCCESS = 200;
    const CODE_BAD_REQUEST = 400;
    const CODE_NOT_FOUND = 404;
    const CODE_NOT_ALLOWED = 403;
    const CODE_CONFLICT = 409;
    const CODE_UNPROCESSABLE = 422;
    const CODE_INTERNAL_ERROR = 500;

    /** @var ResponseInterface */
    private $response;

    /** @var int */
    private $status = null;

    /** @var array */
    private $json;

    /** @var string|null|\Exception */
    private $error;

    public final function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public final function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public final function getStatus(): int
    {
        return $this->status;
    }

    public function setStatusSuccess(): self {
        $this->setStatus(self::CODE_SUCCESS);

        return $this;
    }

    public function setStatusNotFound(): self {
        $this->setStatus(self::CODE_NOT_FOUND);

        return $this;
    }

    public function setStatusUnprocessable(): self {
        $this->setStatus(self::CODE_UNPROCESSABLE);

        return $this;
    }

    public function setStatusNotAllowed(): self {
        $this->setStatus(self::CODE_NOT_ALLOWED);

        return $this;
    }

    public function setStatusBadRequest(): self {
        $this->setStatus(self::CODE_BAD_REQUEST);

        return $this;
    }

    public function setStatusConflict(): self {
        $this->setStatus(self::CODE_CONFLICT);

        return $this;
    }

    public function setStatusInternalError(): self {
        $this->setStatus(self::CODE_INTERNAL_ERROR);

        return $this;
    }

    public function isSuccess(): bool
    {
        return !$this->getError() && ($this->getStatus() === self::CODE_SUCCESS);
    }

    public final function getJson(): array
    {
        return $this->json;
    }

    public final function setJson(array $json): self
    {
        $this->json = $json;

        return $this;
    }

    public final function getError()
    {
        return $this->error;
    }

    public final function setError( $error): self
    {
        $this->error = $error;

        return $this;
    }

    public final function build(): ResponseInterface
    {
        $this->checkRequirements();

        $this->response->getBody()->write(json_encode($this->makeJSONResponse()));

        return $this->response
            ->withStatus($this->status)
            ->withHeader('Content-Type', 'application/json')
        ;
    }

    public function checkRequirements()
    {
        if ($this->status === null) {
            throw new \Exception('No status code provided');
        }
    }


    private function makeJSONResponse(): array
    {
        $json = $this->json;
        $json['success'] = $this->isSuccess();

        if(!$json['success']) {
            if($this->error instanceof \Exception) {
                $errorMessage = $this->error->getMessage();
                $json['error_stack'] = $this->error->getTrace();
            }else if($this->error instanceof \TypeError) {
                $errorMessage = $this->error->getMessage();
                $json['error_stack'] = $this->error->getTrace();
            }else if(is_string($this->error)) {
                $errorMessage = $this->error;
            }else if($this->error === null){
                $errorMessage = 'No error message available';
            }else{
                $errorMessage = (string) $this->error;
            }

            $json['error'] = $errorMessage;
        }

        if(defined('APP_TIMER_START')) {
            $json['time'] = (microtime(true) - APP_TIMER_START).'ms';
        }

        return $json;
    }
}