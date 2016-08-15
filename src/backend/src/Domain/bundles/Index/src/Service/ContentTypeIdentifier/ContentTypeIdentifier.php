<?php
namespace Domain\Index\Service\ContentTypeIdentifier;

use Domain\Feed\Search\Criteria\Criteria\ContentTypeCriteria;
use Domain\IM\Service\ContentTypeIdentifier\ContentTypeIdentifierEntity;
use Domain\Post\Entity\Post;
use Domain\Attachment\LinkMetadata\Types\ImageLinkMetadata;
use Domain\Attachment\LinkMetadata\Types\PageLinkMetadata;
use Domain\Attachment\LinkMetadata\Types\UnknownLinkMetadata;
use Domain\Attachment\LinkMetadata\Types\WebmLinkMetadata;
use Domain\Attachment\LinkMetadata\Types\YoutubeLinkMetadata;
use Domain\Attachment\Service\AttachmentService;

final class ContentTypeIdentifier
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
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
            $attachment = $this->attachmentService->getById($post->getAttachmentIds()[0]);
            
            switch($resource = $attachment->getMetadata()['resource']) {
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