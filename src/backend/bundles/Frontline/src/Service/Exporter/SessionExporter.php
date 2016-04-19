<?php
namespace Frontline\Service\Exporter;

use Frontline\Service\Exporter;

class FrontlineInvalidKeyException extends \Exception {}
class FrontlineKeyNotFoundException extends \Exception {}

class SessionExporter
{
    const SESSION_KEY = 'frontline';

    public function __construct() {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    public function __invoke(): array
    {
        return $_SESSION[self::SESSION_KEY];
    }

    public function set($key, $value) {
        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    public function destroy($key) {
        if($this->has($key)) {
            $_SESSION[self::SESSION_KEY][$key] = null;
        }
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

    public function exportToJSON(): array {
        return $_SESSION[self::SESSION_KEY];
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