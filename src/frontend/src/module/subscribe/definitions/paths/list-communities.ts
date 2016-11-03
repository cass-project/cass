import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface ListCommunities extends Success200
{
    entities: SubscriptionEntity[];
}

export interface ListCommunitiesRequest
{
    limit: number,
    offset: number
}