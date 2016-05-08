<?php
namespace Application\Bootstrap\Scripts;

use Zend\Expressive\Application;

class RouteSetupScript
{
    public function __invoke(Application $app, array $configDirs, string $prefix)
    {
        foreach($configDirs as $configDir) {
            $routeConfigFile = sprintf('%s/routes.php', $configDir);

            if(file_exists($routeConfigFile)) {
                $callback = require $routeConfigFile;

                if(!is_callable($callback)) {
                    throw new \Exception(sprintf('Config `%s` should returns a Callable with Application and prefix argument', $routeConfigFile));
                }

                $callback($app, $prefix);
            }
        }
    }
}