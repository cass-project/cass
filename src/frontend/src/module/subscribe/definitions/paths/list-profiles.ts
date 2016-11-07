import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface ListSubscribeProfiles extends Success200
{
    subscribes: SubscriptionEntity<ProfileEntity>[];
}

export interface ListSubscribeProfileRequest
{
    limit: number,
    offset: number
}