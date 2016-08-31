<?php
namespace Domain\Auth\Middleware\Command;

use CASS\Application\Bundles\Frontline\Service\FrontlineService;
use CASS\Application\Command\Command as CommandInterface;
use Domain\Auth\Formatter\SignInFormatter;
use Domain\Auth\Service\AuthService;

abstract class Command implements CommandInterface
{
    /** @var AuthService */
    protected $authService;

    /** @var FrontlineService */
    protected $frontlineService;

    /** @var  SignInFormatter */
    protected $signInFormatter;

    public function __construct(
        AuthService $authService,
        FrontlineService $frontlineService,
        SignInFormatter $signInFormatter
    ) {
        $this->authService = $authService;
        $this->frontlineService = $frontlineService;
        $this->signInFormatter = $signInFormatter;
    }

}