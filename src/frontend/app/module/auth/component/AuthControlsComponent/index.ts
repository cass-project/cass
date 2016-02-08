import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {AuthService, AuthServiceProvider} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: 'auth-controls',
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES
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
        return this.authService.isAuthenticated;
    }
}
