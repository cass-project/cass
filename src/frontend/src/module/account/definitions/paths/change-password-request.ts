import {Success200} from "../../../common/definitions/common";

export interface ChangePasswordRequest
{
    old_password: string;
    new_password: string;
}

export interface ChangePasswordResponse200 extends Success200
{
    api_key: string;
}