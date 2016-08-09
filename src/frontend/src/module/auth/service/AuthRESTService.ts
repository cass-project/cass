import {Injectable} from "@angular/core";
import {Http} from "@angular/http"

import {SignInRequest} from "../definitions/paths/sign-in";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {SignUpRequest} from "../definitions/paths/sign-up";
import {AuthToken} from "./AuthToken";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";

@Injectable()
export class AuthRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    signIn(request: SignInRequest) {
        return this.handle(this.http.post("/backend/api/auth/sign-in", JSON.stringify(request)));
    }

    signOut() {
        return this.handle(this.http.get("/backend/api/auth/sign-out"));
    }

    signUp(request: SignUpRequest) {
        return this.handle(this.http.put("/backend/api/auth/sign-up", JSON.stringify(request)));
    }
}