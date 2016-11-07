import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {CommunityEntity} from "../../../community/definitions/entity/Community";

export interface SubscribeCommunity extends Success200
{
    subscribe: SubscriptionEntity<CommunityEntity>;
}