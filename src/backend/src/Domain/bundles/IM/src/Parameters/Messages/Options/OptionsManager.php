<?php
namespace Domain\IM\Exception\Query\Options;

use Domain\IM\Exception\Query\DuplicateOptionException;
use Domain\IM\Exception\Query\UnknownOptionException;

final class OptionsManager
{
    /** @var Option[] */
    private $options = [];

    public function __construct(array $options)
    {
        array_map(function(Option $option) {
            $key = get_class($option);

            if(isset($this->options[$key])) {
                throw new DuplicateOptionException(sprintf('Option `%s` is duplicated', $key));
            }

            $this->options[$key] = $option;
        }, $options);
    }

    public function hasOption(string $optionClassName): bool
    {
        return isset($this->options[$optionClassName]);
    }

    public function getOption(string $optionClassName): Option
    {
        if(! isset($this->options[$optionClassName])) {
            throw new DuplicateOptionException(sprintf('Option `%s` not found', $optionClassName));
        }

        return $this->options[$optionClassName];
    }

    public function doWith(string $optionClassName, Callable $callback)
    {
        if($this->hasOption($optionClassName)) {
            $callback($this->getOption($optionClassName));
        }
    }

    public function requireWith(string $optionClassName, Callable $callback)
    {
        if($this->hasOption($optionClassName)) {
            $callback($this->getOption($optionClassName));
        }else{
            throw new UnknownOptionException(sprintf('Option `%s` is required but not found', $optionClassName));
        }
    }
}