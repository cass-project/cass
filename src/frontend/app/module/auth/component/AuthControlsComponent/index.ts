import {Component} from 'angular2/core';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {AuthService, AuthServiceProvider} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: 'auth-controls',
    directives: [
        COMMON_DIRECTIVES
    ],
    providers: [AuthServiceProvider]
})


export class AuthControlsComponent
{
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider) {
        this.authService = authServiceProvider.getInstance();
    }

    isAuthenticated() {
        console.log(this.authService.isAuthenticated);
        return this.authService.isAuthenticated;
    }
}
