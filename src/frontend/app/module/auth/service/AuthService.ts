import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {Router} from "angular2/router";
import {ResponseInterface} from "../../main/ResponseInterface";
import {Cookie} from 'ng2-cookies';
import {BackendError} from '../../main/BackendError';

@Injectable()
export class AuthService
{
    public token: AuthToken;
    public signedIn: boolean = false;
    public lastError: BackendError;

    constructor(private http: Http, private router:Router) {
        this.token = new AuthToken();

        if(Cookie.getCookie('api_key')) {
            this.signedIn = true;
            this.token.setToken(Cookie.getCookie('api_key'));
        }
    }

    public attemptSignIn(request: SignInModel) {
        this.lastError = null;

        console.log(request.remember, 'remember?');
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
                    this.signedIn = true;
                    this.token.setToken(response.api_key);

                    Cookie.setCookie('api_key', response.api_key, remember ? 14 : undefined);
                }else{
                    this.signedIn = false;
                    this.lastError = new BackendError(response);
                }
            },
            error => {
                this.signedIn = false;
                this.lastError = new BackendError(error);
            }
        );
    }

    public signOut() {
        return this.http.get('/backend/api/auth/sign-out').subscribe(
            response => {
                this.signedIn = false;
                this.router.navigate(['Welcome']);

                Cookie.deleteCookie('api_key');
            }
        );
    }
}

class AuthToken
{
    public apiKey: string;

    setToken(apiKey) {
        localStorage.setItem('api_key', apiKey);

        this.apiKey = apiKey;
    }

    reset() {
        localStorage.removeItem('api_key');

        this.apiKey = null;
    }

    hasApiKey() {
        return !!this.apiKey;
    }

    getApiKey(): string {
        if(!this.hasApiKey()) {
            throw new Error('No api_key available');
        }

        return this.apiKey;
    }
}

export interface SignInResponse extends ResponseInterface
{
    api_key: string;
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