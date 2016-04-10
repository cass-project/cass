<?php
namespace Feed\Middleware\Command;

use Common\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Sphinx\SphinxClient;

abstract class Command
{
    private $sphinxClient;

    public function setSphinxClient(SphinxClient $sphinxClient)
    {
        $this->sphinxClient = $sphinxClient;
    }

    protected function getSphinxClient(): SphinxClient
    {
        return $this->sphinxClient;
    }

    abstract public function run(ServerRequestInterface $request);

    public static function factory(ServerRequestInterface $request): Command
    {
        $command = $request->getAttribute('command');
        switch ($command) {
            default:
                throw new CommandNotFoundException(sprintf('Command `%s` not found', $command));
            case '':
                return new DefaultCommand();
            case 'search':
                return new SearchCommand();
        }
    }

}