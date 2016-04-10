<?php
namespace ThemeEditor\Middleware\Command;

use Common\Exception\CommandNotFoundException;
use ThemeEditor\Service\ThemeEditorService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    /** @var ThemeEditorService */
    private $themeEditorService;

    public function setThemeEditorService(ThemeEditorService $themeEditorService)
    {
        $this->themeEditorService = $themeEditorService;
    }

    protected function getThemeEditorService(): ThemeEditorService
    {
        return $this->themeEditorService;
    }

    abstract public function run(ServerRequestInterface $request);

    public static function factory(ServerRequestInterface $request): Command
    {
            $command = $request->getAttribute('command');

        switch ($command) {
            default:
                throw new CommandNotFoundException(sprintf('Command `%s` not found', $command));

            case 'read':
                return new ReadThemeCommand();

            case 'create':
                return new CreateThemeCommand();

            case 'update':
                return new UpdateThemeCommand();

            case 'delete':
                return new DeleteThemeCommand();

            case 'move':
                return new MoveThemeCommand();
        }
    }
}