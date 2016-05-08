<?php
namespace Domain\PostAttachment\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Application\Exception\CommandNotFoundException;
use Domain\PostAttachment\Service\PostAttachmentService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_UPLOAD = 'upload';
    
    /** @var CurrentAccountService */
    protected $currentAccountService;
    
    /** @var PostAttachmentService */
    protected $postAttachmentService;

    public function setCurrentAccountService($currentAccountService): self {
        $this->currentAccountService = $currentAccountService;
        return $this;
    }

    public function setPostAttachmentService($postAttachmentService): self {
        $this->postAttachmentService = $postAttachmentService;
        return $this;
    }

    abstract public function run(ServerRequestInterface $request);

    public static function factory(
        ServerRequestInterface $request,
        CurrentAccountService $currentAccountService,
        PostAttachmentService $postAttachmentService)
    {
        return self::factoryCommand($request->getAttribute('command'))
            ->setCurrentAccountService($currentAccountService)
            ->setPostAttachmentService($postAttachmentService);
    }

    private static function factoryCommand(string $command) {
        switch($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));
            case self::COMMAND_UPLOAD:
                return new UploadCommand();
        }
    }
}