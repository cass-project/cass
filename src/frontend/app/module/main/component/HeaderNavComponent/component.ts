import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router';
import {AuthService, AuthServiceProvider} from './../../../auth/service/AuthService';

@Component({
    selector: 'cass-header-bar',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES
    ],
    providers: [AuthServiceProvider]
})
export class HeaderNavComponent
{
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider) {
        this.authService = authServiceProvider.getInstance();
    }
}