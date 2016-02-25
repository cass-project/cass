<?php
namespace ThemeEditor\Middleware\Request;

use Application\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class DeleteThemeRequest implements RequestParams
{
    /** @var int */
    private $id;

    public function __construct(ServerRequestInterface $request)
    {
        $this->id = (int) $request->getAttribute('themeId');
    }

    public function getId(): int
    {
        return $this->id;
    }
}