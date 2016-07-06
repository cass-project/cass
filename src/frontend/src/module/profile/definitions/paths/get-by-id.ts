import {Success200} from "../../../common/definitions/common";
import {ProfileExtendedEntity} from "../entity/Profile";
import {Response} from "angular2/http";

export interface GetProfileByIdResponse200 extends Success200
{
    entity: ProfileExtendedEntity;
}