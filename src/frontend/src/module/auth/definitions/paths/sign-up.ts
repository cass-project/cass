import {AccountEntity} from "../../../account/definitions/entity/Account";
import {Success200} from "../../../common/definitions/common";
import {ProfileExtendedEntity} from "../../../profile/definitions/entity/Profile";

export interface SignUpRequest
{
    email: string;
    password: string;
    repeat: string;
}

export interface SignUpResponse200 extends Success200
{
    api_key: string;
    account: AccountEntity;
    profiles: ProfileExtendedEntity[];
    frontline: any;
}