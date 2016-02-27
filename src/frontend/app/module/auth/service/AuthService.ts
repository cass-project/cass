import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {Router} from "angular2/router";

@Injectable()
export class AuthServiceProvider
{
    static instance:AuthService;

    constructor(private http: Http, private router:Router) {
        if(AuthServiceProvider.instance == null) {
            AuthServiceProvider.instance = new AuthService(http, router);
        }
    }

    getInstance() {
        return AuthServiceProvider.instance;
    }
}


@Injectable()
export class AuthService
{
    isLoading:boolean = false;

    constructor(private http: Http, private router:Router) {
    }

    public attemptSignIn(login:string, password:string) {
        this.isLoading = true;
        let requestBody;

        if(!this.isAuthenticated()) {
            requestBody = JSON.stringify({
                "login" : login,
                "password" : password
            });
        }

        this.http.post('/backend/api/auth/sign-in', requestBody).subscribe(
            data => AuthService.setToken(data.json()["account_token"]),
            () => {
                AuthService.removeToken();
                this.isLoading = false;
            },
            () => this.isLoading = false
        );
    }

    public attemptSignUp(email:string, phone:string, password:string, passwordAgain:string) {
        this.isLoading = true;
        let requestBody = JSON.stringify({
            "email"         : email,
            "phone"         : phone,
            "password"      : password,
            "passwordAgain" : passwordAgain
        });
        this.http.post('/backend/api/auth/sign-up', requestBody).subscribe(
            data => AuthService.setToken(data.json()["account_token"]),
            () => this.isLoading = false,
            () => this.isLoading = false
        );
    }

    public signOut() {
        this.isLoading = true;
        this.http.get('/backend/api/auth/sign-out').subscribe(
            () => {
                AuthService.removeToken();
                this.router.navigate(['SignIn']);
            },
            () => this.isLoading = false,
            () => this.isLoading = false
        );
    }

    public isAuthenticated() : boolean {
        return !!AuthService.getToken();
    }

    private static setToken(token:string) {
        localStorage.setItem("account_token", token);
    }

    private static getToken() {
        return localStorage.getItem("account_token");
    }

    private static removeToken() {
        localStorage.removeItem("account_token");
    }
}