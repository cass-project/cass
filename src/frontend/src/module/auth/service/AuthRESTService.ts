import {Observable} from "rxjs/Observable";
import {Injectable} from "angular2/core";
import {Http} from "angular2/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {SignInRequest, SignInResponse200} from "../definitions/paths/sign-in";
import {SignUpRequest, SignUpResponse200} from "../definitions/paths/sign-up";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {SignOutResponse200} from "../definitions/paths/sign-out";

@Injectable()
export class AuthRESTService extends AbstractRESTService
{
    constructor(protected  http: Http, protected messages: MessageBusService) {
        super(http, messages);
    }

    signIn(request: SignInRequest): Observable<SignInResponse200>
    {
        return this.handle(this.http.post("/backend/api/auth/sign-in", JSON.stringify(request)));
    }

    signOut(): Observable<SignOutResponse200>
    {
        return this.handle(this.http.get("/backend/api/auth/sign-out"));
    }

    signUp(request: SignUpRequest): Observable<SignUpResponse200>
    {
        return this.handle(this.http.put("/backend/api/auth/sign-up", JSON.stringify(request)));
    }
}