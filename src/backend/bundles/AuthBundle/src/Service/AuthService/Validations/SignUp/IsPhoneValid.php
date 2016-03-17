<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Auth\Service\AuthService\Exceptions\ValidationException;
use Data\Repository\AccountRepository;

class IsPhoneValid extends Validator
{

    public function validate()
    {
        AccountRepository::clearPhone($this->credentials['phone']);
        if ($this->hasPhone() && !$this->isPhone()) {
            throw new ValidationException('The phone must be 10 digits. Country code optional.');
        }
    }

    private function hasPhone() : bool
    {
        return !empty($this->credentials['phone']);
    }

    private function isPhone() : bool
    {
        return strlen(intval($this->credentials['phone'])) > 10;
    }
}