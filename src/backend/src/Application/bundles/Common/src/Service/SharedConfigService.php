<?php
namespace Application\Common\Service;

class SharedConfigService
{
    /**
     * @var array
     */
    private $config = [];

    public function all() {
        return $this->config;
    }

    public function get($key) {
        if(!(isset($this->config[$key]))) {
            throw new \OutOfBoundsException(sprintf('Config key `%s` not found', $key));
        }

        return $this->config[$key];
    }

    public function merge($config) {

        $this->config = array_merge_recursive($this->config, $config);
    }
}