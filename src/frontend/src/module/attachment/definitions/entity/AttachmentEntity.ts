export interface AttachmentEntity<T extends AttachmentMetadata>
{
    id: number;
    sid: string;
    date_created_on: string;
    date_attached_on?: string;
    is_attached: boolean;
    title: string;
    description: string;
    link: {
        url: string;
        resource: string;
        version: number;
        source: {
            source: string;
            origURL: string;
        };
        metadata: T;
    }
    owner?: {
        id: number;
        code: string;
    }
}

export interface AttachmentMetadata {}