import {Success200} from "../../../common/definitions/common";
import {CommunityExtendedEntity} from "../entity/CommunityExtended";

export interface GetCommunityResponse200 extends Success200
{
    entity: CommunityExtendedEntity;
}