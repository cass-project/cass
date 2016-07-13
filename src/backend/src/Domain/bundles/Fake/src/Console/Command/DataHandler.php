<?php

namespace Domain\Fake\Console\Command;


use Domain\Account\Service\AccountService;
use Domain\Profile\Service\ProfileService;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DataHandler
{

    /** @var AccountService */
    protected $accountService;
    /** @var ProfileService  */
    protected $profileService;
    /** @var OutputInterface  */
    protected $output;

    protected $dataFilePath;
    protected $data;

    public function __construct(AccountService $accountService, ProfileService $profileService, OutputInterface $output){
        $this->accountService = $accountService;
        $this->profileService = $profileService;
        $this->output = $output;
    }

    protected function setDataFilePath(string $path)
    {
        if(!file_exists($path)) print_r("file doesn't exists");
        $this->dataFilePath = $path;

        return $this;
    }

    protected function readDataFromJson(){
        if($this->dataFilePath == null) return false;
        $this->data = json_decode( file_get_contents($this->dataFilePath) );

        return $this;
    }

    public function saveData(){ }

    public function readData($file){
        $this->setDataFilePath($file)
            ->readDataFromJson()
        ;
    }
}