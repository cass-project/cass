<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class MoveThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        return [
            'success' => true
        ];
    }
}