<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\RequestInterface;

class DeleteThemeCommand extends Command
{
    public function run(RequestInterface $request)
    {
        return [
            'success' => true
        ];
    }

}