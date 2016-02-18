<?php
namespace ThemeEditor\Middleware\Command;

class ReadThemeCommand extends Command
{
    public function run()
    {
        return [
            'success' => true
        ];
    }
}