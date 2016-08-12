<?php

namespace Domain\Youtube\Console\Command;


use Application\Util\Seek;
use Domain\PostAttachment\Entity\PostAttachment;
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

        $total = $this->attachmentService->getTotalCountAttachments([YoutubeLinkMetadata::RESOURCE_TYPE]);

        $perPage = 10;
        $pages = ceil($total/$perPage);

        if($pages < 0) throw new \Exception('Нет страниц') ;

        for($page = 0; $page < $pages; $page++){

            $output->writeln( sprintf("Страница %s из %s", $page, $pages) );
            $seek = new Seek($perPage, $page*$perPage, $perPage);
            $videos = [];
            $videos = $this->attachmentService->getAttachmentsByCriteria([YoutubeLinkMetadata::RESOURCE_TYPE], $seek);

            $youtubeIds = [];
            foreach($videos as $postAttachmetn){
                /** @var PostAttachment $postAttachmetn */
                $youtubeIds[] = $postAttachmetn->getAttachment()['metadata']['youtubeId'];
            }

            $response = [];
            $response = $this->youtubeService->getMetadataForVideos($youtubeIds);

            foreach($videos as $postAttachmetn){
                $output->writeln(sprintf("наполняем видео: %s = %s",$postAttachmetn->getId(), $postAttachmetn->getAttachment()['metadata']['youtubeId']));

                /** @var PostAttachment $postAttachmetn */
                array_walk($response['items'],function(array $item)use ($postAttachmetn){
                    $youtubeId = $postAttachmetn->getAttachment()['metadata']['youtubeId'];
                    if($youtubeId == $item['id']) {
                        $postAttachmetn->mergeAttachment($item['snippet']);
                        $this->attachmentService->updatePostAttachment($postAttachmetn);
                    }
                });
            }
        }
    }
}