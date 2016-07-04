import {Success200} from "../../../common/definitions/common";
import {AccountEntity} from "../entity/Account";

export interface AppAccessResponse200 extends Success200
{
    access: {
        apps: {
            admin: boolean,
            feedback: boolean,
            reports: boolean
        },
        account:AccountEntity
    }
}