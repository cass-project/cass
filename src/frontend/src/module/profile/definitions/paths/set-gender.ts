import {ProfileGenderEntity, ProfileGender} from "../entity/Profile";

export interface SetGenderRequest
{
    gender: ProfileGender;
}

export interface SetGenderResponse200
{
    gender: ProfileGenderEntity;
}