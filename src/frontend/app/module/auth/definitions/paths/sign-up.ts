import {AccountEntity} from "../../../account/definitions/entity/Account";
import {Success200} from "../../../common/definitions/common";

export interface SignUpResponse200 extends Success200
{
    api_key: string;
    account: AccountEntity;
}