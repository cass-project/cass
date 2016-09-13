import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";
import {PostAttachmentEntity, AttachmentMetadata} from "../../../post-attachment/definitions/entity/PostAttachment";

export interface EditPostRequest
{
    profile_id: number;
    collection_id: number;
    content: string;
    attachments: Array<number>;
    links: PostAttachmentEntity<AttachmentMetadata>[];
}

export interface EditPostResponse200 extends Success200
{
    entity: PostEntity;
}