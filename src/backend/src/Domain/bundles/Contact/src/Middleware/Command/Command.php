<?php
namespace CASS\Domain\Contact\Middleware\Command;

use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Contact\Formatter\ContactFormatter;
use CASS\Domain\Contact\Service\ContactService;

abstract class Command implements \CASS\Application\Command\Command
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