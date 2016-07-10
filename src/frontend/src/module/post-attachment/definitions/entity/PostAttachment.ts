import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface PostAttachmentEntity<T extends PostAttachmentType>
{
    id: number;
    post_id: number;
    attachment_type: string;
    date_created_on: string;
    is_attached_to_post: boolean;
    attachment: any;
}

export interface PostAttachmentType
{
    attachment_type: string;
}

export interface PostLinkEntity extends PostAttachmentType
{
    url: string;
    metadata: any;
}

export interface PostFileAttachmentType extends PostAttachmentType
{
    file: {
        public_path: string;
        storage_path: string;
    }
}

export interface PostAttachmentTypeImage extends PostFileAttachmentType
{
    image: ImageCollection;
}

export interface PostAttachmentTypeWebm extends PostFileAttachmentType
{
}