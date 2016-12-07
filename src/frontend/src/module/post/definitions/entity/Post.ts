import {AttachmentEntity, AttachmentMetadata} from "../../../attachment/definitions/entity/AttachmentEntity";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
import {FeedEntity} from "../../../feed/service/FeedService/entity";
import { PostTypeEntity } from "./PostType";

export interface PostEntity extends FeedEntity
{
    id: number;
    date_created_on: string;
    profile_id: number;
    collection_id: number;
    title: {
        has: boolean;
        value?: string;
    };
    content: string;
    attachments: AttachmentEntity<AttachmentMetadata>[];
    attachment_ids: number[];
    profile: ProfileEntity;
    post_type: PostTypeEntity;
    attitude: {
        state: string,
        likes: number,
        dislikes: number
    };
}

export interface PostIndexedEntity extends PostEntity
{
    _id: string;
}