<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class DeleteThemeRequest implements RESTRequest
{
    /** @var int */
    private $id;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public static function factory(ServerRequestInterface $request) {
        return new static($request->getAttribute('themeId'));
    }

    public function getId() {
        return $this->id;
    }
}