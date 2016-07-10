export interface PostAttachmentEntity<T>
{
    id: number;
    post_id: number;
    attachment_type: string;
    date_created_on: string;
    is_attached_to_post: boolean;
    attachment: T;
}

export interface PostAttachmentType
{
    attachment_type: string;
}
