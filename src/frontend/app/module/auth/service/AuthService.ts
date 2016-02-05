import {Injectable} from 'angular2/core';

@Injectable()
export class AuthService
{
    success: boolean = false;

    constructor() {}

    isAuthenticated() {
        return this.success;
    }

    logIn() {
    }

    logOut() {
    }
}