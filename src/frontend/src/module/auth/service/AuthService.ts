import {Injectable} from 'angular2/core';

import {AuthRESTService} from "./AuthRESTService";
import {FrontlineService} from "../../frontline/service";
import {Account} from './../../account/definitions/entity/Account';
import {SignInRequest, SignInResponse200} from "../definitions/paths/sign-in";
import {SignUpRequest, SignUpResponse200} from "../definitions/paths/sign-up";

@Injectable()
export class AuthService
{
    /** @deprecated Не используйте это свойство в своих компонентах/сервисах */
    public static token: AuthToken;

    constructor(
        private frontline: FrontlineService,
        private api: AuthRESTService
    ) {
        let hasAuth = frontline.session.auth
            && (typeof frontline.session.auth.api_key == "string")
            && (frontline.session.auth.api_key.length > 0);

        if(hasAuth) {
            let auth = frontline.session.auth;

            AuthService.token = new AuthToken(auth.api_key, new Account(auth.account, auth.profiles));
        }
    }

    public getAuthToken(): AuthToken {
        if(! this.isSignedIn()) {
            throw new Error("You're not signed in");
        }

        return AuthService.token;
    }

    public isSignedIn(): boolean {
        return AuthService.token != undefined;
    }
    
    public signUp(request: SignUpRequest) {
        let signUpObservable = this.api.signUp(request);

        signUpObservable.map(res => res.json()).subscribe(
            (response: SignUpResponse200) => {
                AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                this.frontline.merge(response.frontline);
            },
            error => {}
        );

        return signUpObservable;
    }

    public signIn(request: SignInRequest) {
        let signInObservable = this.api.signIn(request);

        signInObservable.map(res => res.json()).subscribe(
            (response: SignInResponse200) => {
                AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                this.frontline.merge(response.frontline);
            },
            error => {}
        );

        return signInObservable;
    }

    public signOut() {
        let request = this.api.signOut();
    
        request.subscribe(
            () => {
                this.getAuthToken().clearAPIKey();
                delete AuthService['token'];
            }
        );
        
        return request;
    }
}

class AuthToken
{
    constructor(public apiKey: string, public account: Account) {
        localStorage.setItem('api_key', apiKey);
    }

    getCurrentProfile() {
        return this.account.profiles.getCurrent();
    }

    clearAPIKey() {
        localStorage.removeItem('api_key');
    }
}