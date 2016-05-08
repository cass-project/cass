<?php
namespace Application\REST\Response;

use Psr\Http\Message\ResponseInterface;

abstract class ResponseBuilder
{
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

    protected final function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public final function getStatus(): int
    {
        return $this->status;
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

    abstract public function isSuccess(): bool;

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

        return $json;
    }
}