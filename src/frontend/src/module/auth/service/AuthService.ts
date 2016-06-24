import {Injectable} from 'angular2/core';
import {Http, URLSearchParams, Response} from 'angular2/http';
import {ResponseInterface} from "../../common/ResponseInterface";
import {BackendError} from '../../common/BackendError';
import {Profile} from './../../profile/definitions/entity/Profile';
import {Account, AccountEntity} from './../../account/definitions/entity/Account';
import {FrontlineService} from "../../frontline/service";
import {AuthRESTService} from "./AuthRESTService";
import {SignInRequest} from "../definitions/paths/sign-in";
import {SignUpRequest} from "../definitions/paths/sign-up";

@Injectable()
export class AuthService
{
    public static token: AuthToken;

    constructor(
        private frontline: FrontlineService)
    {
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

export interface SignInResponse extends ResponseInterface
{
    api_key: string;
    account: AccountEntity;
    profiles: Profile[];
    frontline: any;
}