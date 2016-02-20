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
        let args = new URLSearchParams();
        args.set('login', login);
        args.set('password', password);
        this.isLoading = true;
        this.http.get('/backend/api/auth/sign-in', {search: args})
            .map(res => res.json())
            .subscribe(
                data => this.isAuthenticated = true,
                err => this.isLoading = this.isAuthenticated = false,
                () => this.isLoading = false
            );
    }

    attemptSignUp(email:string, phone:string, password:string, passwordAgain:string){
        let args = new URLSearchParams();
        if(email) args.set('email', email);
        if(phone) args.set('phone', phone);
        args.set('password', password);
        args.set('passwordAgain', passwordAgain);

        this.isLoading = true;
        this.http.get('/backend/api/auth/sign-up', {search: args})
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