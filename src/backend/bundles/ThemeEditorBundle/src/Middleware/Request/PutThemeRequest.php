<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class PutThemeRequest implements RESTRequest
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $parentId;

    public static function factory(ServerRequestInterface $request) {
        $body = json_decode($request->getBody(), true);
        $title = $body['title'];
        $parentId = $body['parent_id'] ?? null;

        $PUTEntityRequest = new static($title);
        $PUTEntityRequest->setParentId($parentId);

        return $PUTEntityRequest;
    }

    public function __construct($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function setParentId(int $parentId = null) {
        $this->parentId = $parentId;
    }
}