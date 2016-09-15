import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {EmailVerificationRequestResponse200} from "../definitions/paths/request";
import {EmailVerificationConfirmResponse200} from "../definitions/paths/confirm";

@Injectable()
export class EmailVerificationRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    requestEmailVerification(newEmail: string): Observable<EmailVerificationRequestResponse200> {
        return this.handle(
            this.http.get(`/backend/api/email-verification/request/${newEmail}`)
        );
    }

    confirmEmailVerification(token: string): Observable<EmailVerificationConfirmResponse200> {
        return this.handle(
            this.http.get(`/backend/api/email-verification/confirm/${token}`)
        );
    }
}