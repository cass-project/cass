<?php
namespace CASS\Domain\Bundles\Post\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Post\PostType\PostTypeFactory;

final class PostTypeFrontlineScript implements FrontlineScript
{
    /** @var PostTypeFactory */
    private $postTypeFactory;

    public function __construct(PostTypeFactory $postTypeFactory)
    {
        $this->postTypeFactory = $postTypeFactory;
    }

    public function tags(): array
    {
        return [
            self::TAG_GLOBAL,
        ];
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'post' => [
                    'types' => $this->postTypeFactory->getPostTypeDefinitions()
                ]
            ]
        ];
    }
}