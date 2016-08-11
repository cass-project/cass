import {Success200} from "../../../common/definitions/common";

export interface CommunityActivateFeatureRequest {
    communityId: number,
    feature:string
}

export interface CommunityActivateFeatureResponse200 extends Success200 {}