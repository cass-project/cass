<?php
namespace Domain\Contact\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Contact\Formatter\ContactFormatter;
use Domain\Contact\Service\ContactService;

abstract class Command implements \Application\Command\Command
{
    /** @var ContactService */
    protected $contactService;

    /** @var ContactFormatter */
    protected $contactFormatter;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    public function __construct(
        ContactService $contactService,
        ContactFormatter $contactFormatter,
        CurrentAccountService $currentAccountService
    ) {
        $this->contactService = $contactService;
        $this->contactFormatter = $contactFormatter;
        $this->currentAccountService = $currentAccountService;
    }

}