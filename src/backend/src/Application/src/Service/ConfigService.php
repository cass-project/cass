<?php
namespace CASS\Application\Service;

class ConfigService
{
    /**
     * @var array
     */
    private $config = [];

    public function all()
    {
        return $this->config;
    }

    public function has($key)
    {
        return isset($this->config[$key]);
    }

    public function get($key)
    {
        if(!(isset($this->config[$key]))) {
            throw new \OutOfBoundsException(sprintf('Config key `%s` not found', $key));
        }

        return $this->config[$key];
    }

    public function merge($config)
    {

        $this->config = array_merge_recursive($this->config, $config);
    }
}