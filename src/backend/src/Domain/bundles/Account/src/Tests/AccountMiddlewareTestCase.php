<?php
namespace Domain\Account\Tests;

use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
abstract class AccountMiddlewareTestCase extends MiddlewareTestCase
{
    protected function requestDeleteRequest(): RESTRequest
    {
        return $this->request('PUT', '/protected/account/request-delete');
    }

    protected function requestCancelDeleteRequest(): RESTRequest
    {
        return $this->request('DELETE', '/protected/account/cancel-request-delete');
    }

    protected function requestChangePassword(array $json): RESTRequest
    {
        return $this->request('POST', '/protected/account/change-password')
            ->setParameters($json);
    }

    protected function requestAppAccess(): RESTRequest
    {
        return $this->request('GET', '/protected/account/app-access');
    }
}