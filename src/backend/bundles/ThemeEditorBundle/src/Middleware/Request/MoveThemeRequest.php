<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class MoveThemeRequest implements RequestParams
{
    /** @var int */
    private $themeId;

    /** @var int */
    private $parentThemeId;

    /** @var int */
    private $position;

    public function __construct(ServerRequestInterface $request)
    {
        $this->themeId = (int) $request->getAttribute('themeId');
        $this->parentThemeId = (int) $request->getAttribute('parentThemeId');
        $this->position = (int) $request->getAttribute('position');
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function getParentThemeId(): int
    {
        return $this->parentThemeId;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}