import {AccountEntity} from "../../../account/definitions/entity/Account";
import {Success200} from "../../../common/definitions/common";

export interface SignInResponse200 extends Success200
{
    account: AccountEntity;
    api_key: string;
}