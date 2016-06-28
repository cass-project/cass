import {Injectable} from 'angular2/core';

import {Account} from './../../account/definitions/entity/Account';
import {FrontlineService} from "../../frontline/service";
import {SignInRequest, SignInResponse200} from "../definitions/paths/sign-in";
import {AuthRESTService} from "./AuthRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";

@Injectable()
export class AuthService
{
    public static token: AuthToken;

    constructor(
        private frontline: FrontlineService,
        private api: AuthRESTService,
        private messages: MessageBusService
    ) {
        let hasAuth = frontline.session.auth
            && (typeof frontline.session.auth.api_key == "string")
            && (frontline.session.auth.api_key.length > 0);

        if(hasAuth) {
            let auth = frontline.session.auth;

            AuthService.token = new AuthToken(auth.api_key, new Account(auth.account, auth.profiles));
        }
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

    public signIn(request: SignInRequest) {
        let signInObservable = this.api.signIn(request);

        signInObservable.map(res => res.json()).subscribe(
            (response: SignInResponse200) => {
                AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                this.frontline.merge(response.frontline);
            },
            error => {
                console.log(error);
            }
        );

        return signInObservable;
    }

    public signOut() {
        let request = this.api.signOut();
    
        request.subscribe(
            () => {
                AuthService.getAuthToken().clearAPIKey();
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