<?php
namespace CASS\Application;

use CASS\Domain\Bundles\Attachment\AttachmentBundle;
use CASS\Domain\Bundles\Auth\AuthBundle;
use CASS\Domain\Bundles\Avatar\AvatarBundle;
use CASS\Domain\Bundles\Collection\CollectionBundle;
use CASS\Domain\Bundles\Colors\ColorsBundle;
use CASS\Domain\Bundles\Community\CommunityBundle;
use CASS\Domain\Bundles\Contact\ContactBundle;
use CASS\Domain\Bundles\Feed\FeedBundle;
use CASS\Domain\Bundles\Feedback\FeedbackBundle;
use CASS\Domain\Bundles\IM\IMBundle;
use CASS\Domain\Bundles\Index\IndexBundle;
use CASS\Domain\Bundles\OpenGraph\OpenGraphBundle;
use CASS\Domain\Bundles\Post\PostBundle;
use CASS\Domain\Bundles\Profile\ProfileBundle;
use CASS\Domain\Bundles\ProfileCommunities\ProfileCommunitiesBundle;
use CASS\Domain\Bundles\Theme\ThemeBundle;

return [
    'php-di' => [
        'config.api-docs.excluded-bundles' => [
            ContactBundle::class,
            FeedBundle::class,
            IMBundle::class,
            IndexBundle::class,
            OpenGraphBundle::class,
        ]
    ]
];