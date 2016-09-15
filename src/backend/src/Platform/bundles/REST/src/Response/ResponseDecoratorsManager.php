<?php
namespace ZEA2\Platform\Bundles\REST\Response;

use ZEA2\Platform\Bundles\REST\Response\Decorators\ResponseDecorator;

final class ResponseDecoratorsManager implements Decorators\ResponseDecorator
{
    /** @var ResponseDecorator[] */
    private $decorators = [];

    public function attach(ResponseDecorator $decorator): self
    {
        $this->decorators[get_class($decorator)] = $decorator;

        return $this;
    }

    public function detach(ResponseDecorator $decorator): self
    {
        if(isset($this->decorators[get_class($decorator)])) {
            unset($this->decorators[get_class($decorator)]);
        }

        return $this;
    }

    public function detachByClassName(string $decorator): self
    {
        if(isset($this->decorators[$decorator])) {
            unset($this->decorators[$decorator]);
        }

        return $this;
    }

    public function clear()
    {
        $this->decorators = [];
    }

    public function has(ResponseDecorator $decorator): bool
    {
        return isset($this->decorators[get_class($decorator)]);
    }

    public function decorate(ResponseBuilder $builder, array $response): array
    {
        foreach($this->decorators as $decorator) {
            $response = $decorator->decorate($builder, $response);
        }

        return $response;
    }
}