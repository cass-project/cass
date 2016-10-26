import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface ListProfiles extends Success200
{
    entities: SubscriptionEntity[];
}

export interface ListProfileRequest extends Success200
{
    limit: number,
    offset: number
}