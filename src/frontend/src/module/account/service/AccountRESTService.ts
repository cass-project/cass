import {Injectable} from "angular2/core";
import {Http} from "angular2/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class AccountRESTService extends AbstractRESTService
{
    constructor(protected  http: Http, protected messages: MessageBusService) {
        super(http, messages);
    }

    appAccess() {
        return this.handle(this.http.get('/backend/api/protected/account/app-access'));
    }

    changePassword(old_password: string, new_password: string) {
        return this.handle(this.http.post('/backend/api/protected/account/change-password', JSON.stringify({
            old_password: old_password,
            new_password: new_password
        })));
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

    switchProfile(profileId: number) {
        return this.handle(this.http.post(`/backend/api/protected/account/switch/to/profile/${profileId}`, ''));
    }
}