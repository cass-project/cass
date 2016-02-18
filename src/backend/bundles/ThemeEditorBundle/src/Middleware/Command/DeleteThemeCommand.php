<?php
namespace ThemeEditor\Middleware\Command;

class DeleteThemeCommand extends Command
{
    public function run()
    {
        return [
            'success' => true
        ];
    }
}