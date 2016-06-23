import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {SignInRequest} from "../definitions/paths/sign-in";
import {SignUpRequest} from "../definitions/paths/sign-up";
import {AuthService} from "./AuthService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class AuthRESTService extends AbstractRESTService
{
    constructor(protected  http: Http, protected messages: MessageBusService) {
        super(http, messages);
    }

    signIn(request: SignInRequest)
    {
        return this.handle(this.http.post("/backend/api/auth/sign-in", JSON.stringify(request)));
    }

    signOut()
    {
        return this.handle(this.http.get("/backend/api/auth/sign-out"));
    }

    signUp(request: SignUpRequest)
    {
        return this.handle(this.http.put("/backend/api/auth/sign-up", JSON.stringify(request)));
    }
}