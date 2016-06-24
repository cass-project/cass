import {Success200} from "../../../common/definitions/common";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface UnreadProfileMessagesResponse200 extends Success200
{
    cache: {
        profiles: ProfileEntity[];
    },
    unread: {
        source_profile_id: number;
        count: number;
    }[];
}