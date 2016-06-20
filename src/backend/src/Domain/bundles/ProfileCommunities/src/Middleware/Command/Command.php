<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Application\REST\Response\ResponseBuilder;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements \Application\Command\Command
{
    /** @var ProfileCommunitiesService */
    protected $profileCommunitiesService;

    public function __construct(ProfileCommunitiesService $profileCommunitiesService)
    {
        $this->profileCommunitiesService = $profileCommunitiesService;
    }
}