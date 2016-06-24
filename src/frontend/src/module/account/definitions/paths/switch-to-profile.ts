import {Profile} from "../../../profile/definitions/entity/Profile";

export interface SwitchToProfileResponse200
{
    success: boolean;
    profile: Profile;
}