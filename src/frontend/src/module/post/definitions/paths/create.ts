import {PostLinkEntity} from "../../../post-attachment/definitions/entity/PostAttachment";
import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";

export interface CreatePostRequest
{
    post_type: number;
    profile_id: number;
    collection_id: number;
    content: string;
    attachments: Array<number>;
    links: PostLinkEntity[];
}

export interface CreatePostResponse200 extends Success200
{
    entity: PostEntity;
}