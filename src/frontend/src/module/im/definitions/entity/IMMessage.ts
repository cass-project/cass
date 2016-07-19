import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface IMMessageEntity
{
    id: string,
    author: ProfileEntity,
    date_created: string,
    content: string,
    attachments: number[]
}

export interface IMMessageExtendedEntity extends IMMessageEntity
{
    send_status: {
        code: ("complete" | "processing" | "fail"),
        error_text?: string
    };
}