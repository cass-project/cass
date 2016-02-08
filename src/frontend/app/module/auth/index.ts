import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';

import {AuthControlsComponent} from './component/AuthControlsComponent/index';
import {AuthService, AuthServiceProvider} from './service/AuthService';
import {SignInComponent} from './component/SignInComponent/index';

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        COMMON_DIRECTIVES,
        AuthControlsComponent
    ],
    providers:[AuthServiceProvider]
})

@RouteConfig([
    {
        path: '/sign-in',
        name: 'SignIn',
        component: SignInComponent,
        useAsDefault: true
    }
])

export class AuthComponent
{
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider){
        this.authService = authServiceProvider.getInstance();
    }

    isUserSigningIn() {
        return this.authService.isUserSigningIn;
    }
}