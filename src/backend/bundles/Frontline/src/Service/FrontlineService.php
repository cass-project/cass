<?php
namespace Frontline\Service;

class FrontlineInvalidKeyException extends \Exception {}
class FrontlineKeyNotFoundException extends \Exception {}

class FrontlineService
{
    const SESSION_KEY = 'frontline';

    public function __construct() {
        if (!$_SESSION[self::SESSION_KEY]) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    public function export($key, $value) {
        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    public function get($key) {
        $this->validateKey($key);

        if ($this->has($key)) {
            return $_SESSION[self::SESSION_KEY][$key];
        } else {
            throw new FrontlineKeyNotFoundException(sprintf('Key `%s` not found', $key));
        }
    }

    public function has($key): bool {
        $this->validateKey($key);

        return isset($_SESSION[self::SESSION_KEY]);
    }

    public function importToJSON(): string {
        return json_encode($_SESSION[self::SESSION_KEY], JSON_UNESCAPED_UNICODE);
    }

    private function validateKey($input) {
        $isString = is_string($input);
        $hasRequiredLength = (strlen($input) > 3) && (strlen($input) < 127);
        $hasOnlyValidSymbols = preg_match('/^([a-zA-Z0-9\_]+)$/', $input);

        if (!($isString && $hasRequiredLength && $hasOnlyValidSymbols)) {
            throw new FrontlineInvalidKeyException('Invalid key');
        }
    }
}