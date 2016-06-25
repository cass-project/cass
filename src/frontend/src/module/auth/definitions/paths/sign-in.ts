import {AccountEntity} from "../../../account/definitions/entity/Account";
import {Success200} from "../../../common/definitions/common";
import {ProfileExtendedEntity} from "../../../profile/definitions/entity/Profile";

export interface SignInRequest
{
    email: string;
    password: string;
}

export interface SignInResponse200 extends Success200
{
    api_key: string;
    account: AccountEntity;
    profiles: ProfileExtendedEntity[];
    frontline: any;
}