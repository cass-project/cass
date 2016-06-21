import {Success200} from "../../../common/definitions/common";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
import {ProfileMessageEntity} from "../entity/ProfileMessage";

export interface ProfileMessagesResponse200 extends Success200
{
    source_profile: ProfileEntity;
    messages: ProfileMessageEntity[];
    total: string;
}