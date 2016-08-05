<?php

namespace Domain\Youtube\Service;


class YoutubeService
{
    private $googleApiKey = 'AIzaSyDqNT5-tmhDEAlX71yyWa2ntYHBUTC-rUk';

    public function getMetadataForVideos(array $ids): array
    {
        $ids = implode(',', $ids);

        $url = sprintf('https://www.googleapis.com/youtube/v3/videos?key=%s&part=snippet&id=%s', $this->googleApiKey, $ids);

        return json_decode(file_get_contents($url), TRUE);
    }
}