import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";

export interface CreatePostRequest
{
    post_type: number;
    profile_id: number;
    collection_id: number;
    force_theme_id?: number;
    title?: string;
    content: string;
    attachments: Array<number>;
}

export interface CreatePostResponse200 extends Success200
{
    entity: PostEntity;
}