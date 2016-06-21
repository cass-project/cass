import {ProfileGenderEntity} from "../entity/Profile";

export interface SetGenderRequest
{
    gender: string;
}

export interface SetGenderResponse200
{
    gender: ProfileGenderEntity;
}