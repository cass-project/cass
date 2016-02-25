import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';

@Injectable()
export class AuthServiceProvider
{
    static instance:AuthService;

    constructor(private http: Http) {
        if(AuthServiceProvider.instance == null) {
            AuthServiceProvider.instance = new AuthService(http);
        }
    }

    getInstance() {
        return AuthServiceProvider.instance;
    }
}


@Injectable()
export class AuthService {
    isAuthenticated:boolean = false;
    isLoading:boolean = false;

    constructor(private http: Http) {

    }

    attemptSignIn(login:string, password:string) {
        this.isLoading = true;
        this.http.post('/backend/api/auth/sign-in', JSON.stringify({
                "login"         : login,
                "password"      : password
        }))
            .map(res => res.json())
            .subscribe(
                data => {
                    this.isAuthenticated = true;
                    localStorage.setItem('account_token',data['account_token']);
                },
                err => this.isLoading = this.isAuthenticated = false,
                () => this.isLoading = false
            );
    }

    attemptSignUp(email:string, phone:string, password:string, passwordAgain:string){

        this.isLoading = true;
        this.http.post('/backend/api/auth/sign-up', JSON.stringify({
                "email"         : email,
                "phone"         : phone,
                "password"      : password,
                "passwordAgain" : passwordAgain
        }))
            .map(res => res.json())
            .subscribe(
                data => this.isAuthenticated = true,
                err => this.isLoading = this.isAuthenticated = false,
                () => this.isLoading = false
            );

    }

    logOut(){
        this.isAuthenticated = false;
    }
}