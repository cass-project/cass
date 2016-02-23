<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class UpdateThemeRequest implements RESTRequest
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public static function factory(ServerRequestInterface $request) {
        $body = json_decode($request->getBody(), true);
        $themeId = $request->getAttribute('themeId');
        $title = $body['title'] ?? null;

        $updateThemeRequest = new static($themeId);

        if($title !== null) {
            $updateThemeRequest->setTitle($title);
        }

        return $updateThemeRequest;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }
}