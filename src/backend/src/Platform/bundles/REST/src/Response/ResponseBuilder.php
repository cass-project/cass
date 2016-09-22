<?php
namespace ZEA2\Platform\Bundles\REST\Response;

use Psr\Http\Message\ResponseInterface;

abstract class ResponseBuilder
{
    const CODE_SUCCESS = 200;
    const CODE_BAD_REQUEST = 400;
    const CODE_NOT_FOUND = 404;
    const CODE_NOT_ALLOWED = 403;
    const CODE_CONFLICT = 409;
    const CODE_UN_PROCESSABLE = 422;
    const CODE_INTERNAL_ERROR = 500;

    /** @var ResponseInterface */
    private $response;

    /** @var int */
    private $status = null;

    /** @var array */
    private $json = [];

    /** @var string|null|\Exception */
    private $error;

    /** @var ResponseDecoratorsManager */
    private $decorators;

    public final function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->decorators = new ResponseDecoratorsManager();

        $this->initDecorators($this->decorators);
    }

    protected abstract function initDecorators(ResponseDecoratorsManager $decoratorsManager);

    public final function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public final function getStatus(): int
    {
        return $this->status;
    }

    public function getDecorators(): ResponseDecoratorsManager
    {
        return $this->decorators;
    }

    public function setStatusSuccess(): self
    {
        $this->setStatus(self::CODE_SUCCESS);

        return $this;
    }

    public function setStatusNotFound(): self
    {
        $this->setStatus(self::CODE_NOT_FOUND);

        return $this;
    }

    public function setStatusNotProcessable(): self
    {
        $this->setStatus(self::CODE_UN_PROCESSABLE);

        return $this;
    }

    public function setStatusNotAllowed(): self
    {
        $this->setStatus(self::CODE_NOT_ALLOWED);

        return $this;
    }

    public function setStatusBadRequest(): self
    {
        $this->setStatus(self::CODE_BAD_REQUEST);

        return $this;
    }

    public function setStatusConflict(): self
    {
        $this->setStatus(self::CODE_CONFLICT);

        return $this;
    }

    public function setStatusInternalError(): self
    {
        $this->setStatus(self::CODE_INTERNAL_ERROR);

        return $this;
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

    public function hasError()
    {
        return $this->error !== null;
    }

    public final function setError($error): self
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
            ->withHeader('Content-Type', 'application/json');
    }

    public function checkRequirements()
    {
        if($this->status === null) {
            throw new \Exception('No status code provided');
        }
    }

    private function makeJSONResponse(): array
    {
        return $this->decorators->decorate($this, $this->json);
    }
}