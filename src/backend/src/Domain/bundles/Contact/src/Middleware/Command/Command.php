<?php
namespace CASS\Domain\Bundles\Contact\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Contact\Formatter\ContactFormatter;
use CASS\Domain\Bundles\Contact\Service\ContactService;

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