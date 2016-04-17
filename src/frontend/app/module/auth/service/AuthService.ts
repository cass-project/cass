import {Cookie} from 'ng2-cookies/ng2-cookies';
import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {Router} from "angular2/router";
import {ResponseInterface} from "../../common/ResponseInterface";
import {BackendError} from '../../common/BackendError';
import {Profile, ProfileEntity} from './../../profile/entity/Profile';
import {Account, AccountEntity} from './../../account/entity/Account';
import {FrontlineService} from "../../frontline/service";

@Injectable()
export class AuthService
{
    public static token: AuthToken;
    public lastError: BackendError;

    constructor(private http: Http, private frontline: FrontlineService) {
        console.log(frontline);
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

    public attemptSignIn(request: SignInModel) {
        this.lastError = null;

        return this.signIn(this.http.post('/backend/api/auth/sign-in', JSON.stringify(request)), request.remember);
    }

    public attemptSignUp(request: SignUpModel) {
        this.lastError = null;

        return this.signIn(this.http.post('/backend/api/auth/sign-up', JSON.stringify(request)), request.remember);
    }

    private signIn(http, remember = false) {
        return http.map(res => res.json()).subscribe(
            response => {
                if(response.success) {
                    AuthService.token = new AuthToken(response.api_key, new Account(response.account, response.profiles));
                }else{
                    this.lastError = new BackendError(response);
                }
            },
            error => {
                this.lastError = new BackendError(error);
            }
        );
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
}

interface SignInModel
{
    email: string;
    password: string;
    remember?: boolean;
}

interface SignUpModel
{
    email: string;
    password: string;
    repeat: string;
    remember?: boolean;
}