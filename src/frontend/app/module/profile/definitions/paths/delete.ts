import {Success200} from "../../../common/definitions/common";

export interface DeleteProfileResponse200 extends Success200
{
    current_profile_id: number;
}