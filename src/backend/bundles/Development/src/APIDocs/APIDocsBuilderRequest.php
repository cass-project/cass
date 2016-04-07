<?php
namespace Development\APIDocs;

use Cocur\Chain\Chain;

class APIDocsBuilderRequest
{
    /**
     * @var string[]
     */
    private $directories = [];

    public function addDirectory($directory) {
        if(!(is_dir($directory))) {
            throw new \Exception(sprintf('Path `%s` is not a directory', $directory));
        }

        $this->directories[] = $directory;
    }

    public function removeDirectory($directory) {
        $this->directories = Chain::create($this->directories)
            ->filter(function($input) use ($directory) {
                return $input !== $directory;
            })
        ;
    }

    public function clearDirectories() {
        $this->directories = [];
    }

    public function getDirectories() {
        return $this->directories;
    }
}