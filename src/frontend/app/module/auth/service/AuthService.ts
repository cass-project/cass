import {Injectable} from 'angular2/core';
import {Http, URLSearchParams, Response} from 'angular2/http';
import {ResponseInterface} from "../../common/ResponseInterface";
import {BackendError} from '../../common/BackendError';
import {Profile} from './../../profile/definitions/entity/Profile';
import {Account, AccountEntity} from './../../account/definitions/entity/Account';
import {FrontlineService} from "../../frontline/service";
import {Observable} from "rxjs/Observable";

@Injectable()
export class AuthService
{
    public static token: AuthToken;

    constructor(
        private http: Http,
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
        if(! this.isSignedIn()) {
            throw new Error("You're not signed in.");
        }

        return AuthService.token;
    }

    public attemptSignIn(request: SignInModel): Promise<SignInResponse> {
        return this.signIn(this.http.post('/backend/api/auth/sign-in', JSON.stringify(request)));
    }

    public attemptProviderSignIn(provider: String): Promise<SignInResponse> {
        return this.signIn(this.http.get(`/backend/api/auth/sign-in/oauth/${provider}`));
    }

    public attemptSignUp(request: SignUpModel): Promise<SignInResponse> {
        return this.signIn(this.http.put('/backend/api/auth/sign-up', JSON.stringify(request)));
    }

    public getAuthToken() {
        return AuthService.getAuthToken();
    }

    private signIn(http: Observable<Response>): Promise<SignInResponse> {
        return new Promise((resolve, reject) => {
            http
                .map(res => res.json())
                .subscribe(
                    response => {
                        AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                        this.frontline.merge(response.frontline);
                        resolve(response);
                    },
                    error => {
                        reject((new BackendError(error)).message);
                    }
                )
        });
    }

    public signOut() {
        return this.http.get('/backend/api/auth/sign-out').subscribe(
            response => {
                if(AuthService.token) {
                    AuthService.token.clearAPIKey();
                    AuthService.token = null;
                }
            }
        );
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

interface SignInModel
{
    email: string;
    password: string;
}

export interface SignUpModel
{
    email: string;
    password: string;
    repeat: string;
}