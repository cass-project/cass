<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Application\REST\Response\ResponseBuilder;
use Domain\Auth\Service\CurrentAccountService;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements \Application\Command\Command
{
    /** @var ProfileCommunitiesService */
    protected $profileCommunitiesService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    public function __construct(
        ProfileCommunitiesService $profileCommunitiesService,
        CurrentAccountService $currentAccountService
    ) {
        $this->profileCommunitiesService = $profileCommunitiesService;
        $this->currentAccountService = $currentAccountService;
    }
}