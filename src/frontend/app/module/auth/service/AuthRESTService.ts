import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {SignInRequest} from "../definitions/paths/sign-in";

export class AuthRESTService extends AbstractRESTService
{
    signIn(request: SignInRequest)
    {
        return this.handle(this.http.post("/auth/sign-in", JSON.stringify(request)));
    }
}