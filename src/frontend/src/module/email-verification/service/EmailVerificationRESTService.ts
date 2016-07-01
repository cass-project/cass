import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class EmailVerificationRESTService extends AbstractRESTService {
    constructor(
        protected http: Http,
        protected auth: AuthService,
        protected messages: MessageBusService
    ) { super(http, auth, messages) }

    emailVerification(token: string)
    {
        return this.handle(this.http.get(`/backend/api/email-verification/confirm/${token}`));
    }

    RequestEmailVerification(newEmail: string)
    {
        return this.handle(this.http.get(`/backend/api/email-verification/request/${newEmail}`));
    }
}