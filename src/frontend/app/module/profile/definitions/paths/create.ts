import {Success200} from "../../../common/definitions/common";
import {ProfileEntity} from "../entity/Profile";

export interface CreateProfileResponse200 extends Success200
{
    entity: ProfileEntity;
}