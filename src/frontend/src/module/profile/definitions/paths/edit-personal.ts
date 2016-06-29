import {Success200} from "../../../common/definitions/common";
import {ProfileEntity} from "../entity/Profile";

export interface EditPersonalRequest
{
    gender?: string;
    avatar?: boolean;
    method: string;
    last_name: string;
    first_name: string;
    middle_name: string;
    nick_name: string;
}

export interface EditPersonalResponse200 extends Success200
{
    entity: ProfileEntity;
}