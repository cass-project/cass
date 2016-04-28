<?php
namespace Profile\Middleware\Command;

use Auth\Service\CurrentAccountService;
use Common\Exception\CommandNotFoundException;
use Profile\Entity\Profile;
use Profile\Service\ProfileService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_GET = 'get';
    const COMMAND_GREETINGS_AS = 'greetings-as';
    const COMMAND_IMAGE_UPLOAD = 'image-upload';
    const COMMAND_EDIT_PERSONAL = 'edit-personal';
    const COMMAND_SWITCH = 'switch';
    const COMMAND_EXPERT_IN = 'expert-in';
    const COMMAND_INTERESTING_IN = 'interesting-in';

    /** @var ProfileService */
    protected $profileService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    private function setProfileService(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function setCurrentAccountService($currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public static function factory(ServerRequestInterface $request, ProfileService $profileService, CurrentAccountService $currentAccountService): Command
    {
        $command = self::factoryCommand($request->getAttribute('command'), $request->getMethod() );
        $command->setProfileService($profileService);
        $command->setCurrentAccountService($currentAccountService);

        return $command;
    }

    private static function factoryCommand(string $command, string $method) {
        switch ($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));

            case self::COMMAND_CREATE:
                return new CreateCommand();

            case self::COMMAND_DELETE:
                return new DeleteCommand();

            case self::COMMAND_GET:
                return new GetCommand();

            case self::COMMAND_GREETINGS_AS:
                return new GreetingsAsCommand();

            case self::COMMAND_IMAGE_UPLOAD:
                return new ImageUploadCommand();

            case self::COMMAND_EDIT_PERSONAL:
                return new EditPersonalCommand();

            case self::COMMAND_SWITCH:
                return new SwitchCommand();

            case self::COMMAND_EXPERT_IN:
                switch($method){
                    default: throw new CommandNotFoundException(sprintf("Command %s::%s, method: %s not found", self::class, $command, $method));
                    case 'POST': return new ExpertInPostCommand();
                    case 'PUT': return new ExpertInPutCommand();
                    case 'DELETE': return new ExpertInDeleteCommand();
                }

            case self::COMMAND_INTERESTING_IN:
                switch($method){
                    default: throw new CommandNotFoundException(sprintf("Command %s::%s, method: %s not found", self::class, $command, $method));
                    case 'POST': return new InterestingInPostCommand();
                    case 'PUT': return new InterestingInPutCommand();
                    case 'DELETE': return new ExpertInDeleteCommand();
                }
        }
    }

    abstract public function run(ServerRequestInterface $request);

    protected function validateProfileId($input): int
    {
        $isInteger = filter_var($input, FILTER_VALIDATE_INT);
        $isMoreThanZero = (int) $input > 0;

        if(!($isInteger && $isMoreThanZero)) {
            throw new \InvalidArgumentException('Invalid profileId');
        }

        return (int) $input;
    }

    protected function validateIsOwnProfile($profileId): bool
    {
        $profiles = $this->currentAccountService->getCurrentAccount()->getProfiles();


        foreach($profiles as $profile){
            if($profile instanceof Profile){
                if ($profile->getId() == $profileId) return TRUE;
            }
        }

        return false;
    }
}
