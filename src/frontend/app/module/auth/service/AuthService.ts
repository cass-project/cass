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
    isAuthenticating:boolean = false;
    success;

    constructor(private http: Http) {

    }

    attemptSignIn(login:string, password:string) {
        let args = new URLSearchParams();
        args.set('login', login);
        args.set('password', password);
        this.isAuthenticating = true;
        this.http.get('/backend/api/auth/sign-in', {search: args})
            .map(res => res.json())
            .subscribe(
                data => this.isAuthenticated = true,
                err => this.isAuthenticating = this.isAuthenticated = false,
                () => this.isAuthenticating = false
            );
    }

    logOut(){
        this.isAuthenticated = false;
    }
}