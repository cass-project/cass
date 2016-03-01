<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Psr\Http\Message\ServerRequestInterface;

abstract class Validator
{

    protected $credentials;

    public function setCredentials(ServerRequestInterface $request) : self
    {
        $this->credentials = json_decode($request->getBody(), true);
        return $this;
    }

    abstract public function validate();
}