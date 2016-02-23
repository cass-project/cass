<?php
namespace ThemeEditor\Middleware\Request;

use Application\REST\RESTRequest;
use Psr\Http\Message\ServerRequestInterface;

class MoveThemeRequest implements RESTRequest
{
    /** @var int */
    private $themeId;

    /** @var int */
    private $parentThemeId;

    /** @var int */
    private $position;

    public function __construct(int $themeId, int $parentThemeId, int $position) {
        $this->themeId = $themeId;
        $this->parentThemeId = $parentThemeId;
        $this->position = $position;
    }

    public static function factory(ServerRequestInterface $request) {
        $themeId = $request->getAttribute('themeId');
        $themeNewParentId = $request->getAttribute('parentThemeId');
        $position = $request->getAttribute('position');

        return new static($themeId, $themeNewParentId, $position);
    }

    public function getThemeId() {
        return $this->themeId;
    }

    public function getParentThemeId() {
        return $this->parentThemeId;
    }

    public function getPosition() {
        return $this->position;
    }
}