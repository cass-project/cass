import {Success200} from "../../../common/definitions/common";
import {CommunityEntity} from "../entity/Community";

export interface GetCommunityResponse200 extends Success200
{
    entity: CommunityEntity;
}