import {Success200} from "../../../common/definitions/common";

export interface CommunityDeactivateFeatureRequest {
    communityId: number,
    feature:string
}

export interface CommunityDectivateFeatureResponse200 extends Success200 {}