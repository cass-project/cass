import {Success200} from "../../../common/definitions/common";

export interface CommunityIsActivatedFeatureRequest
{
    communityId: number;
    feature: string;
}

export interface CommunityIsActivatedFeatureResponse200 extends Success200
{
    is_feature_active: boolean;
}