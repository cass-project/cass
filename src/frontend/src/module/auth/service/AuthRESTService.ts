import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Rx";

import {RESTService} from "../../common/service/RESTService";
import {SignInRequest, SignInResponse200} from "../definitions/paths/sign-in";
import {SignUpRequest, SignUpResponse200} from "../definitions/paths/sign-up";
import {SignOutResponse200} from "../definitions/paths/sign-out";

export interface AuthRESTServiceInterface
{
    signIn(request: SignInRequest): Observable<SignInResponse200>;
    signUp(request: SignUpRequest): Observable<SignUpResponse200>;
    signOut(): Observable<SignOutResponse200>;
}

@Injectable()
export class AuthRESTService implements AuthRESTServiceInterface
{
    constructor(
        private rest: RESTService
    ) {}

    signIn(request: SignInRequest): Observable<SignInResponse200> {
        return this.rest.post("/backend/api/auth/sign-in", request);
    }

    signUp(request: SignUpRequest): Observable<SignUpResponse200> {
        return this.rest.put("/backend/api/auth/sign-up", request);
    }

    signOut(): Observable<SignOutResponse200> {
        return this.rest.get("/backend/api/auth/sign-out");
    }
}