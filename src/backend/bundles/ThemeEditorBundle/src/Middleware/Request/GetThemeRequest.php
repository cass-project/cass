<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class GetThemeRequest implements  RESTRequest
{
    /**
     * @var array
     */
    private $criteria = [];

    public static function factory(ServerRequestInterface $request) {
        return new static();
    }

    /**
     * @return array
     */
    public function getCriteria() {
        return $this->criteria;
    }

    public final function setCriteria(array $criteria) {
        throw new \Exception("Wrong idea m8. Check `git log` and ask me why.");
    }
}