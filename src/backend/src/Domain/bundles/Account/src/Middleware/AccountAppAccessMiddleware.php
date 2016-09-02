<?php
namespace CASS\Domain\Bundles\Account\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Domain\Bundles\Account\Service\AccountAppAccessService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class AccountAppAccessMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;
    
    /** @var AccountAppAccessService */
    private $accountAppAccessService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        AccountAppAccessService $accountAppAccessService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->accountAppAccessService = $accountAppAccessService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $account = $this->currentAccountService->getCurrentAccount();
        $access = $this->accountAppAccessService->hasAppAccess($account)
            ? $this->accountAppAccessService->getAppAccess($account)
            : $this->accountAppAccessService->getDefaultAppAccess($account);

        return (new GenericResponseBuilder($response))
            ->setStatusSuccess()
            ->setJson([
                'access' => $access->toJSON()
            ])
            ->build();
    }
}