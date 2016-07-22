import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
export interface ProfileMessageExtendedEntity extends ProfileMessageEntity
{
    send_status: {
        status: ProfileIMFeedSendStatus,
        error_text?: string
    };
}

export interface ProfileMessageEntity
{
    id?: number;
    author:ProfileEntity,
    date_created: string;
    content: string;
    attachments: {}[];
}

export enum ProfileIMFeedSendStatus {
    Complete = <any>"complete",
    Processing = <any>"processing",
    Fail = <any>"fail",
}