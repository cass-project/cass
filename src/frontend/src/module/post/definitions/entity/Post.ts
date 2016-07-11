import {PostAttachmentEntity} from "../../../post-attachment/definitions/entity/PostAttachment";

export interface PostEntity
{
    id: number;
    date_created_on: string;
    author_profile_id: number;
    collection_id: number;
    content: string;
    attachments: PostAttachmentEntity<any>[];
}