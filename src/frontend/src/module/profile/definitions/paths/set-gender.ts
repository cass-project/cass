import {ProfileGenderEntity, ProfileGender} from "../entity/Profile";
import {Success200} from "../../../common/definitions/common";

export interface SetGenderRequest
{
    gender: ProfileGender;
}

export interface SetGenderResponse200 extends Success200
{
    gender: ProfileGenderEntity;
}