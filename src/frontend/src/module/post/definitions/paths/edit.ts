import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";
import {AttachmentEntity, AttachmentMetadata} from "../../../attachment/definitions/entity/AttachmentEntity";

export class EditPostRequest
{
    profile_id: number;
    collection_id: number;
    title: string;
    content: string;
    attachments: Array<number>;
    links: AttachmentEntity<AttachmentMetadata>[];
}

export interface EditPostResponse200 extends Success200
{
    entity: PostEntity;
}