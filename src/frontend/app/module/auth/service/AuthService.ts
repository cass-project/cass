import {Injectable} from 'angular2/core';
import {AuthService} from './AuthService';

@Injectable()
export class AuthServiceProvider
{
    static instance:AuthService;

    constructor() {
        if(AuthServiceProvider.instance == null) {
            AuthServiceProvider.instance = new AuthService();
        }
    }

    getInstance() {
        return AuthServiceProvider.instance;
    }
}

export class AuthService {
    isAuthenticated:boolean = false;

    attemptSignIn(login:string, password:string) {
        this.isAuthenticated = !!(login == 'admin' && password == '1234');

        return this.isAuthenticated;
    }

    logOut(){
        this.isAuthenticated = false;
    }
}