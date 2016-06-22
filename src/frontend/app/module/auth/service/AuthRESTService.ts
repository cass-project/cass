import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {SignInRequest} from "../definitions/paths/sign-in";
import {SignUpRequest} from "../definitions/paths/sign-up";
import {AuthService} from "./AuthService";
import {Account} from "../../account/definitions/entity/Account";

export class AuthRESTService extends AbstractRESTService
{
    signIn(request: SignInRequest)
    {
        return this.handle(this.http.post("/auth/sign-in", JSON.stringify(request)));
    }

    signOut()
    {
        return this.handle(this.http.get("/auth/sign-out"));
    }

    signUp(request: SignUpRequest)
    {
        return this.handle(this.http.put("/auth/sign-up", JSON.stringify(request)));
    }
}