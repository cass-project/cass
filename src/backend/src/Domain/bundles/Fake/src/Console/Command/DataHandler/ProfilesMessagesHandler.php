<?php

namespace Domain\Fake\Console\Command\DataHandler;


use Domain\Account\Service\AccountService;
use Domain\Fake\Console\Command\DataHandler;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\PostType\Types\DefaultPostType;
use Domain\Post\Service\PostService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use Symfony\Component\Console\Output\OutputInterface;

class ProfilesMessagesHandler extends DataHandler
{
    private $profileMessages;
    /** @var  Profile */
    private $profile;

    /** @var PostService $postService */
    private $postService;

    public function __construct(AccountService  $accountService,
                                ProfileService $profileService,
                                OutputInterface $output, PostService $postService)
    {
        parent::__construct($accountService,$profileService,$output );
        $this->postService = $postService;
    }



    public function setProfile(Profile $profile){
        $this->profile = $profile;
        return $this;
    }

    public function readProfileMessages(int $jsonProfileId){
        $this->profileMessages = [];
        $this->profileMessages = array_filter($this->data, function(\stdClass $message) use($jsonProfileId){
            return ((int)$message->author_id) === $jsonProfileId;
        });
        return $this;
    }

    public function saveProfileMessages(){
        foreach($this->profileMessages as $message){
            $this->saveProfileMessage($message);
        }

        return $this;
    }

    public function saveProfileMessage(\stdClass $message)
    {
        $profileId = (int)$this->profile->getCollections()->getItems()[0]->getId();
        $postType = new DefaultPostType();
        $postParameters = new CreatePostParameters($postType->getIntCode(),
                                                   $this->profile->getId(),
                                                   $profileId,

        );

        $this->postService->createPost($postParameters);
    }

}