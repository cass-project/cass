<?php

namespace Domain\Fake\Console\Command\DataHandler;


use Application\Util\Definitions\Point;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Fake\Console\Command\DataHandler;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;

class ProfilesHandler extends DataHandler
{
    const AVATARS_DIR = __DIR__."/../../Resources/Data/Images/avatars/";

    public function saveData(){
        $profilesMessagesHandler = new ProfilesMessagesHandler($this->accountService, $this->profileService,$this->postService,$this->output);
        $profilesMessagesHandler->readData(__DIR__ . "/../../../Resources/Data/JSON/feed.json");


        foreach($this->data as $profileJson){
            $profile = $this->saveProfile($profileJson);
            $profilesMessagesHandler
                ->setProfile($profile)
                ->readProfileMessages((int)$profileJson->id)
                ->saveProfileMessages();
            die();
        }
    }

    protected function saveProfile(\stdClass $profileJson){
        $account = $this->accountService->createAccount($profileJson->email, '1234');
        /** @var Profile $profile */
        $profile = $account->getCurrentProfile();
        $profile->setGender(Profile\Gender\Gender::createFromIntCode((int)$profileJson->gender));
        $parameters = new EditPersonalParameters(
            'n', FALSE,
            $profileJson->username == NULL ? '' : $profileJson->username,
            $profileJson->surname == NULL ? '' : $profileJson->surname,
            $profileJson->patronymic == NULL ? '' : $profileJson->patronymic,
            $profileJson->nickname == NULL ? '' : $profileJson->nickname
        );

        $this->profileService->updatePersonalData($profile->getId(), $parameters);

        $avatarPath = sprintf("%s%s", self::AVATARS_DIR, $profileJson->avatar);

        if(file_exists($avatarPath)){
            list($width, $height) = getimagesize($avatarPath);

            if(!is_null($width)&&!is_null($height)){
                $maxSize = $width <= $height ? $width : $height ;
                $this->profileService->uploadImage($profile->getId(), new UploadImageParameters($avatarPath, new Point(0,0), new Point($maxSize,$maxSize)));
            }
        }

        $this->output->writeln([
                                   "Account ID:{$account->getId()}",
                                   "Account email:{$account->getEmail()}",
                               ]);
        return $profile;
    }

    public function readData($file){
        return $this->setDataFilePath($file)
             ->readDataFromJson()
        ;
    }
}