<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class MoveThemeRequest implements RequestParams
{
    /** @var int */
    private $themeId;

    /** @var int|null */
    private $parentThemeId;

    /** @var int */
    private $position;

    public function __construct(ServerRequestInterface $request)
    {
        $this->themeId = (int) $request->getAttribute('themeId');
        $this->position = (int) $request->getAttribute('position');

        switch($parentId = $request->getAttribute('parentThemeId')) {
            case 0:
            case null:
            case 'null':
            case 'root':
            case 'none':
                $this->parentThemeId = 0;
                break;

            default:
                $this->parentThemeId = (int) $parentId;
                break;
        }
    }

    public function getThemeId(): int
    {
        return $this->themeId;
    }

    public function getParentThemeId()
    {
        return $this->parentThemeId;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}