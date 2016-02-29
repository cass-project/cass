<?php
namespace ThemeEditor\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\GetThemeRequest;

class ReadThemeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();

        if($themeId = $request->getAttribute('themeId', false)) {
            $entity = $themeEditorService->get((int) $themeId);

            return [
                'entity' => $entity->toJSON()
            ];
        }else{
            $entities = $themeEditorService->read();

            return [
                'entities' => $entities,
                'total' => count($entities),
            ];
        }
    }
}