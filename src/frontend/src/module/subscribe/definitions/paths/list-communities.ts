import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {CommunityEntity} from "../../../community/definitions/entity/Community";

export interface ListSubscribeCommunities extends Success200
{
    subscribes: SubscriptionEntity<CommunityEntity>[];
}

export interface ListSubscribeCommunitiesRequest
{
    limit: number,
    offset: number
}