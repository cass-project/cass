import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';

@Injectable()
export class AuthServiceProvider
{
    static instance:AuthService;

    constructor(private http: Http) {
        let credentials = {
            login: 'admin',
            password: '1234'
        };

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

    constructor(private http: Http) {}

    attemptSignIn(login:string, password:string) {
        let credentials = {
            login: login,
            password: password
        };

        let args = new URLSearchParams();
        args.set('login', login);
        args.set('password', password)

        console.log(credentials);

        this.http.get('/backend/api/auth/sign-in', {
            search: args
        })
            .map(res => res.json())
            .subscribe(
                data => console.log,
                err => console.log);


        this.isAuthenticated = !!(login == 'admin' && password == '1234');

        return this.isAuthenticated;
    }

    logOut(){
        this.isAuthenticated = false;
    }
}