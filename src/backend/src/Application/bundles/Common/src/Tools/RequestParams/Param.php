<?php
namespace Application\Common\Tools\RequestParams;

class ParamIsRequiredException extends \Exception {}

class Param
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    public function __construct($data, string $key, bool $required = false)
    {
        $this->key = $key;

        if (is_array($data)) {
            $this->value = $data[$key] ?? null;
        } else {
            $this->value = $data->$key ?? null;
        }

        if ($required && !$this->has()) {
            throw new ParamIsRequiredException(sprintf('Param `%s` is required', $key));
        }
    }

    private function has(): bool
    {
        return $this->value !== null;
    }

    public function value()
    {
        return $this->value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function on(Callable $runThisIfParamIsAvailable): self
    {
        if ($this->has()) {
            $runThisIfParamIsAvailable($this->value, $this->key);
        }

        return $this;
    }

    public function none(Callable $runThisIfParamsIsNotAvailable): self
    {
        if (!($this->has())) {
            $runThisIfParamsIsNotAvailable($this->key);
        }

        return $this;
    }
}