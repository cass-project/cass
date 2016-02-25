<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Application\REST\SchemaRESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class DeleteThemeRequest extends SchemaRESTRequest
{
    /** @var int */
    private $id;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public static function factory(ServerRequestInterface $request)
    {
        // TODO: Implement factory() method.
    }
}