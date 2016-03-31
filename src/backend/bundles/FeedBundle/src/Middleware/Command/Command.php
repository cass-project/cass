<?php
namespace Feed\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Sphinx\SphinxClient;

abstract class Command
{
    private $sphinxService;

    public function setSphinxService(SphinxClient $sphinxService)
    {
        $this->sphinxService = $sphinxService;
    }

    protected function getSphinxService(): SphinxClient
    {
        return $this->sphinxService;
    }

    abstract public function run(ServerRequestInterface $request);

    public static function factory(ServerRequestInterface $request): Command
    {
        $command = $request->getAttribute('command');
        switch ($command) {
            default:
                throw new CommandNotFoundException(sprintf('Command `%s` not found', $command));
            case 'search':
                return new SearchCommand();
        }
    }

}