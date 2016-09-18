import {AccountEntity} from "../entity/Account";
import {Success200} from "../../../common/definitions/common";

export interface CurrentAccountResponse200 extends Success200
{
    account: AccountEntity;
}