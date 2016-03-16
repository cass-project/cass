import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';

import {AuthControlsComponent} from './component/AuthControlsComponent/index';
import {AuthService} from './service/AuthService';
import {SignInComponent} from './component/SignInComponent/index';
import {SignUpComponent} from './component/SignUpComponent/index';
import {LogOutComponent} from './component/LogOutComponent/index';

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        COMMON_DIRECTIVES,
        AuthControlsComponent
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})

@RouteConfig([
    {
        path: '/sign-in',
        name: 'SignIn',
        component: SignInComponent,
        useAsDefault: true
    },
    {
        path: '/sign-up',
        name: 'SignUp',
        component: SignUpComponent,
    },
    {
        path: '/logout',
        name: 'Logout',
        component: LogOutComponent,
    }
])

export class AuthComponent
{
    constructor(public authService:AuthService){}
}