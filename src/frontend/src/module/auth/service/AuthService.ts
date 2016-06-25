import {Injectable} from 'angular2/core';

import {Account} from './../../account/definitions/entity/Account';
import {FrontlineService} from "../../frontline/service";
import {SignInRequest} from "../definitions/paths/sign-in";
import {AuthRESTService} from "./AuthRESTService";

@Injectable()
export class AuthService
{
    public static token: AuthToken;

    constructor(private frontline: FrontlineService, private api: AuthRESTService) {
        let hasAuth = frontline.session.auth && (typeof frontline.session.auth.api_key == "string") && (frontline.session.auth.api_key.length > 0);

        if(hasAuth) {
            let auth = frontline.session.auth;

            AuthService.token = new AuthToken(auth.api_key, new Account(auth.account, auth.profiles));
        }
    }

    static getGreetings() {
        return AuthService.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().greetings
            : 'Anonymous'
    }

    static isSignedIn() {
        return AuthService.token instanceof AuthToken;
    }

    static getAuthToken() {
        return AuthService.token;
    }

    public attemptSignIn(request: SignInRequest) {
        this.api.signIn(request).subscribe(
            response => {
                AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                this.frontline.merge(response.frontline);
            }
        );
    }

    public getAuthToken() {
        return AuthService.getAuthToken();
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