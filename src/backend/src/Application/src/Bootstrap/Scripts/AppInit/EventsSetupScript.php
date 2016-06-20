<?php
namespace Application\Bootstrap\Scripts\AppInit;

use Application\Bootstrap\Scripts\AppInitScript;
use Application\Bundle\Bundle;
use Application\Service\BundleService;
use Evenement\EventEmitter;
use Zend\Expressive\Application;

class EventsSetupScript implements AppInitScript
{
    public function __invoke(Application $app)
    {
        $eventEmitter = $app->getContainer()->get(EventEmitter::class); /** @var EventEmitter $eventEmitter */
        $bundleService = $app->getContainer()->get(BundleService::class); /** @var BundleService $bundleService */

        $configDirs = array_map(function(Bundle $bundle) {
            return $bundle->getConfigDir();
        }, $bundleService->getBundles());

        foreach($configDirs as $configDir) {
            $this->setupEvents($app, $eventEmitter, sprintf('%s/%s', $configDir, 'events.php'));
        }
    }

    private function setupEvents(Application $app, EventEmitter $emitter, $eventConfigFile)
    {
        if(file_exists($eventConfigFile)) {
            $callback = require $eventConfigFile;

            if(!is_callable($callback)) {
                throw new \Exception(sprintf('Event config `%s` should returns a Callable with EventEmitter and Container argument', $eventConfigFile));
            }

            $callback($emitter, $app->getContainer());
        }
    }
}