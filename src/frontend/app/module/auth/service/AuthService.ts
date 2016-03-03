import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {Router} from "angular2/router";
import {ResponseInterface} from "../../main/ResponseInterface";

@Injectable()
export class AuthService
{
    public isLoading: boolean = false;
    public signedIn: boolean = false;
    public error: string;

    private token: string;

    constructor(private http: Http, private router:Router) {}

    public attemptSignIn(login:string, password:string) {
        this.error = null;
        this.isLoading = true;

        let httpHandler = this.http.post('/backend/api/auth/sign-in', JSON.stringify({
            "login" : login,
            "password" : password
        }));

        httpHandler.map(res => res.json()).debounceTime(400).subscribe(
            response => {
                if(response['success']) {
                    this.token = response['account_token'];
                    this.signedIn = true;
                    this.router.navigate(['Welcome']);
                }

                this.isLoading = false;
            },
            err => {
                let errData = err.json();

                if(errData.error) {
                    this.error = errData.error;
                }else{
                    this.error = 'Unknown error. Check your internet connection.'
                }

                this.isLoading = false;
            }
        );

        return httpHandler;
    }

    public attemptSignUp(email:string, password:string, passwordAgain:string) {
        this.isLoading = true;

        let httpHandler = this.http.post('/backend/api/auth/sign-up', JSON.stringify({
            "email"         : email,
            "password"      : password,
            "passwordAgain" : passwordAgain
        }));

        httpHandler.subscribe(
            response => {

            },
            err => this.isLoading = false
        );

        return httpHandler;
    }

    public signOut() {
        this.isLoading = true;

        let httpHandler = this.http.get('/backend/api/auth/sign-out');

        httpHandler.subscribe(
            () => {
                this.token = null;
                this.signedIn = false;
                this.router.navigate(['SignIn']);
            },
            () => this.isLoading = false
        );

        return httpHandler;
    }
}

export interface SignInResponse extends ResponseInterface
{
    account_token: string;
}