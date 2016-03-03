<?php
namespace ThemeEditor\Middleware\Command;

use Cocur\Chain\Chain;
use Data\Entity\Theme;
use Psr\Http\Message\ServerRequestInterface;
use ThemeEditor\Middleware\Request\GetThemeRequest;

class ReadThemeCommand extends Command
{
    const MODE_ENTITIES_AS_PLAIN = 'entities';
    const MODE_ENTITIES_AS_TREE = 'entities-tree';

    public function run(ServerRequestInterface $request)
    {
        $themeEditorService = $this->getThemeEditorService();

        if($themeId = $request->getAttribute('themeId', false)) {
            $entity = $themeEditorService->get((int) $themeId);

            return [
                'entity' => $entity->toJSON()
            ];
        }else{
            $mode = $request->getAttribute('mode');

            if($mode == self::MODE_ENTITIES_AS_PLAIN) {
                $entities = Chain::create($themeEditorService->read())
                    ->map(function(Theme $theme) {
                        return $theme->toJSON();
                    })
                    ->array
                ;

                return [
                    'total' => count($entities),
                    'entities' => $entities
                ];
            }else if($mode == self::MODE_ENTITIES_AS_TREE) {
                return [
                    'entities' => $themeEditorService->readTree(),
                ];
            }else{
                throw new \Exception('Unknown mode');
            }
        }
    }
}