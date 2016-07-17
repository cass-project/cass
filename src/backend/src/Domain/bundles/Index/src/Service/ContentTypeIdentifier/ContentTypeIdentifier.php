<?php
namespace Domain\Index\Service\ContentTypeIdentifier;

use Domain\Feed\Search\Criteria\Criteria\ContentTypeCriteria;
use Domain\IM\Service\ContentTypeIdentifier\ContentTypeIdentifierEntity;
use Domain\Post\Entity\Post;
use Domain\PostAttachment\LinkMetadata\Types\ImageLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\PageLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\UnknownLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\WebmLinkMetadata;
use Domain\PostAttachment\LinkMetadata\Types\YoutubeLinkMetadata;
use Domain\PostAttachment\Service\PostAttachmentService;

final class ContentTypeIdentifier
{
    /** @var PostAttachmentService */
    private $attachmentService;

    public function __construct(PostAttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function detectContentType(ContentTypeIdentifierEntity $entity): string
    {
        return $entity->getContentType();
    }
    
    public function detectContentTypeOfPost(Post $post): string
    {
        if(count($post->getAttachmentIds())) {
            $attachment = $this->attachmentService->getPostAttachmentById($post->getAttachmentIds()[0]);
            
            switch($resource = $attachment->getAttachment()['resource']) {
                default:
                    throw new \Exception(sprintf('Unknown resource `%s`', $resource));

                case YoutubeLinkMetadata::RESOURCE_TYPE:
                    return ContentTypeCriteria::CONTENT_TYPE_VIDEO;

                case PageLinkMetadata::RESOURCE_TYPE:
                    return ContentTypeCriteria::CONTENT_TYPE_LINK;

                case ImageLinkMetadata::RESOURCE_TYPE:
                    return ContentTypeCriteria::CONTENT_TYPE_IMAGE;

                case WebmLinkMetadata::RESOURCE_TYPE:
                    return ContentTypeCriteria::CONTENT_TYPE_VIDEO;

                case UnknownLinkMetadata::RESOURCE_TYPE:
                    return ContentTypeCriteria::CONTENT_TYPE_TEXT;
            }
        }else{
            return ContentTypeCriteria::CONTENT_TYPE_TEXT;
        }
    }
}