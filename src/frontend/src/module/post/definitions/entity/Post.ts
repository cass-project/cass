import {PostAttachmentEntity} from "../../../post-attachment/definitions/entity/PostAttachment";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface PostEntity
{
    id: number;
    date_created_on: string;
    author_profile_id: number;
    collection_id: number;
    content: string;
    attachments: PostAttachmentEntity<any>[];
    profile: ProfileEntity;
}