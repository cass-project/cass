import {Success200} from "../../../common/definitions/common";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
import {ProfileMessageEntity} from "../entity/ProfileMessage";

export interface ProfileMessagesRequest
{

    criteria: {
        seek: {
            offset: number,
            limit: number
        },
        cursor?: {
            id: string
        }
    };
    options?: {
        markAsRead: number[]
    }

}

export interface ProfileMessagesResponse200 extends Success200
{
    source: {
        code:MessagesSourceType,
        entity:ProfileEntity,
    };
    messages:ProfileMessageEntity[];
}

export enum MessagesSourceType {
    Profile = <any>"profile",
    Community = <any>"community"
}