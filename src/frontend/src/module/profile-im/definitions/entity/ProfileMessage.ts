export interface ProfileMessageEntity
{
    id: number;
    date_created_on: string;
    source_profile_id: number;
    target_profile_id: number;
    read_status: ProfileMessageReadStatusEntity;
    content: string;
}

export interface ProfileMessageReadStatusEntity
{
    is_read: boolean;
    date_read: string;
}