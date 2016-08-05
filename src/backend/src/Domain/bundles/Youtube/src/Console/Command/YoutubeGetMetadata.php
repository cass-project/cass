<?php

namespace Domain\Youtube\Console\Command;


use Application\Util\Seek;
use Domain\PostAttachment\LinkMetadata\Types\YoutubeLinkMetadata;
use Domain\PostAttachment\Service\AttachmentTypeDetector;
use Domain\PostAttachment\Service\PostAttachmentService;
use Domain\Youtube\Service\YoutubeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YoutubeGetMetadata extends Command
{

    /** @var  PostAttachmentService $attachmentService */
    private $attachmentService;
    private $youtubeService;

    private $configOauth2Google;



    public function __construct(array $configOauth2Google, YoutubeService $youtubeService, PostAttachmentService $attachmentService){
        $this->attachmentService = $attachmentService;
        $this->youtubeService = $youtubeService;
        $this->configOauth2Google = $configOauth2Google;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('youtube:get:metadata')
            ->setDescription('loads video metadata from youtube');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $seek = new Seek(100, 0, 100);

        $videos = $this->attachmentService->getAttachmentsByCriteria([YoutubeLinkMetadata::RESOURCE_TYPE], $seek);

        print_r(count($videos));

//        $response = $this->youtubeService->getMetadataForVideos(['EQbF-4G7X9E', 'LbaDJ0PBzeI']);

//        print_r($response['items'][0]);

    }



}