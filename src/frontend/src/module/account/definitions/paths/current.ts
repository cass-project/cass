import {AccountEntity} from "../entity/Account";

export interface CurrentResponse200
{
    success: boolean;
    account: AccountEntity;
}