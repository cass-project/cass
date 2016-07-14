<?php

namespace Domain\Fake\Console\Command;


use Domain\Account\Service\AccountService;
use Domain\Post\Service\PostService;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Profile\Service\ProfileService;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DataHandler
{
    /** @var AccountService */
    protected $accountService;
    /** @var ProfileService  */
    protected $profileService;
    /** @var PostService $postService */
    protected $postService;
    /** @var PostAttachmentService $postAttachmentService */
    protected $postAttachmentService;
    /** @var OutputInterface  */
    protected $output;
    protected $dataFilePath;
    protected $data;

    public function __construct(AccountService $accountService, ProfileService $profileService, PostService $postService, PostAttachmentService $attachmentService, OutputInterface $output){
        $this->accountService        = $accountService;
        $this->profileService        = $profileService;
        $this->postService           = $postService;
        $this->postAttachmentService = $attachmentService;
        $this->output                = $output;
    }

    final protected function setDataFilePath(string $path)
    {
        if(!file_exists($path)) print_r("file doesn't exists");
        $this->dataFilePath = $path;
        return $this;
    }

    final protected function readDataFromJson(){
        if($this->dataFilePath == null) return false;
        $this->data = json_decode( file_get_contents($this->dataFilePath) );
        return $this;
    }

    public function saveData(){ }

    final public function readData($file){
        $this->setDataFilePath($file)
            ->readDataFromJson()
        ;
        return $this;
    }
}