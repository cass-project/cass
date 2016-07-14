export interface ProfileMessageExtendedEntity extends ProfileMessageEntity
{
    send_status: {
        status: ProfileIMFeedSendStatus,
        error_text?: string
    };
}

export interface ProfileMessageEntity
{
    id: number;
    date_created_on: string;
    source_profile_id: number;
    target_profile_id: number;
    read_status: {
        is_read: boolean,
        date_read: string
    };
    content: string;
}

export enum ProfileIMFeedSendStatus {
    Complete = <any>"complete",
    Processing = <any>"processing",
    Fail = <any>"fail",
}