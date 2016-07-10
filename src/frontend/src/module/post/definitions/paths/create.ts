import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";
import {PostAttachmentEntity} from "../../../post-attachment/definitions/entity/PostAttachment";
import {LinkAttachment} from "../../../post-attachment/definitions/entity/attachment/LinkAttachment";
import {YouTubeLinkAttachment} from "../../../post-attachment/definitions/entity/attachment/YouTubeLinkAttachment";

export interface CreatePostRequest
{
    post_type: number;
    profile_id: number;
    collection_id: number;
    content: string;
    attachments: Array<number>;
    links: PostAttachmentEntity<LinkAttachment|YouTubeLinkAttachment>[];
}

export interface CreatePostResponse200 extends Success200
{
    entity: PostEntity;
}