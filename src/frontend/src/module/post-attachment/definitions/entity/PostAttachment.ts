export interface PostAttachmentEntity<T extends AttachmentMetadata>
{
    id: number;
    sid: string;
    date_created_on: string;
    is_attached: boolean;
    link: {
        url: string;
        resource: string;
        source: {
            source: string;
            origURL: string;
        };
        metadata: T;
    }
    date_attached_on?: string;
    owner?: {
        id: number;
        code: string;
    }
}

export interface AttachmentMetadata {}