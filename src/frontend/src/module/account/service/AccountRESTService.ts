import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Rx";

import {RESTService} from "../../common/service/RESTService";
import {AppAccessResponse200} from "../definitions/paths/app-access";
import {ChangePasswordResponse200} from "../definitions/paths/change-password-request";
import {RequestDeleteResponse200} from "../definitions/paths/request-delete";
import {CancelRequestDeleteResponse200} from "../definitions/paths/cancel-delete-request";
import {CurrentAccountResponse200} from "../definitions/paths/current-account";

export interface AccountRESTServiceInterface
{
    appAccess(): Observable<AppAccessResponse200>;
    changePassword(old_password: string, new_password: string): Observable<ChangePasswordResponse200>;
    getCurrentAccount(): Observable<CurrentAccountResponse200>;
    requestDelete(): Observable<RequestDeleteResponse200>;
    cancelRequestDelete(): Observable<CancelRequestDeleteResponse200>;
}

@Injectable()
export class AccountRESTService implements AccountRESTServiceInterface
{
    constructor(private service: RESTService) {}

    appAccess(): Observable<AppAccessResponse200> {
        return this.service.get('/backend/api/protected/account/app-access');
    }

    changePassword(old_password: string, new_password: string): Observable<ChangePasswordResponse200> {
        let url = '/backend/api/protected/account/change-password';
        let params = {
            old_password: old_password,
            new_password: new_password
        };

        return this.service.post(url, params);
    }

    getCurrentAccount(): Observable<CurrentAccountResponse200> {
        return this.service.get(`/backend/api/protected/account/current`);
    }

    requestDelete(): Observable<RequestDeleteResponse200> {
        return this.service.delete(`/backend/api/protected/account/request-delete`);
    }

    cancelRequestDelete(): Observable<CancelRequestDeleteResponse200> {
        return this.service.delete(`/backend/api/protected/account/cancel-request-delete`);
    }
}