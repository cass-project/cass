<?php
namespace Domain\Account\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;

/**
 * @backupGlobals disabled
 */
abstract class AccountMiddlewareTestCase extends MiddlewareTestCase
{
    protected function requestDeleteRequest(): RESTRequest {
        return $this->request('PUT', '/protected/account/request-delete');
    }

    protected function requestCancelDeleteRequest(): RESTRequest {
        return $this->request('DELETE', '/protected/account/cancel-request-delete');
    }

    protected function requestChangePassword(array $json): RESTRequest {
        return $this->request('POST', '/protected/account/change-password')
            ->setParameters($json);
    }
}