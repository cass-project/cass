import {Injectable} from "@angular/core";
import {Http, Headers} from "@angular/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class AccountRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    appAccess() {
        let authHeader = new Headers();
        if(this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        return this.handle(this.http.get('/backend/api/protected/account/app-access', {headers: authHeader}));
    }

    changePassword(old_password: string, new_password: string) {
        let authHeader = new Headers();
        if(this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post('/backend/api/protected/account/change-password', JSON.stringify({
            old_password: old_password,
            new_password: new_password
        }), {headers: authHeader}));
    }

    getCurrentAccount() {
        return this.handle(this.http.get(`/backend/api/protected/account/current`));
    }

    requestDelete() {
        return this.handle(this.http.put(`/backend/api/protected/account/request-delete`, ''));
    }

    cancelRequestDelete() {
        return this.handle(this.http.delete(`/backend/api/protected/account/cancel-request-delete`));
    }
}