<?php
namespace Domain\Community\Entity\Community;

class CommunityImage
{
    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPath;

    public function __construct(string $storagePath, string $publicPath)
    {
        if(! (is_file($storagePath) && file_exists($storagePath))) {
            throw new \Exception('File `%s` does\'nt exists');
        }

        $this->storagePath = $storagePath;
        $this->publicPath = $publicPath;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }
}