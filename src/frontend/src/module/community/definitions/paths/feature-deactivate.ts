import {Success200} from "../../../common/definitions/common";

export interface CommunityDeactivateFeatureRequest
{
    communityId: number;
    feature: string;
}

export interface CommunityDeactivateFeatureResponse200 extends Success200 {}