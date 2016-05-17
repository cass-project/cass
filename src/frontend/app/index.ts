/// <reference path="./../typings/main.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../node_modules/reset.css/reset.css');
require('./styles/index.head.scss');

import {bootstrap} from 'angular2/platform/browser';
import {Component, provide} from 'angular2/core';
import {ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {HTTP_PROVIDERS, BaseRequestOptions, RequestOptions} from 'angular2/http';
import {CORE_DIRECTIVES} from 'angular2/common';
import {AuthService} from './module/auth/service/AuthService';
import {frontline, FrontlineService} from "./module/frontline/service";
import {SidebarComponent} from "./module/sidebar/index";
import {AuthComponent} from "./module/auth/component/Auth/index";
import {AuthComponentService} from "./module/auth/component/Auth/service";
import {RouterOutlet} from "angular2/router";
import {RouteConfig} from "angular2/router";
import {LandingComponent} from "./module/landing/index";
import {ProfileRoute} from "./module/profile/route/ProfileRoute/index";
import {ProfileComponent} from "./module/profile/index";
import {ProfileComponentService} from "./module/profile/service";
import {AccountComponent} from "./module/account/index";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    providers: [
        AuthComponentService,
        ProfileComponentService,
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AuthComponent,
        AccountComponent,
        ProfileComponent,
        SidebarComponent,
        RouterOutlet
    ]
})
@RouteConfig([
    {
        name: 'Landing',
        path: '/',
        component: LandingComponent,
        useAsDefault: true
    },
    {
        name: 'Profile',
        path: '/profile/...',
        component: ProfileRoute
    }
])
class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}

class OAuthRequestOptions extends BaseRequestOptions {
    constructor () {
        super();

        this.headers.append('Content-type', 'application/json');

        if(AuthService.isSignedIn()) {
            this.headers.set('X-Api-Key', AuthService.getAuthToken().apiKey);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        document.getElementById('loading').remove();

        bootstrap(
            <any>App, [
                provide(FrontlineService, {useValue: new FrontlineService(session)}),
                provide(AuthService, { useClass: AuthService }),
                ROUTER_PROVIDERS,
                HTTP_PROVIDERS,
                provide(RequestOptions, {useClass: OAuthRequestOptions}),
                provide(Window, {useValue: session})
            ]).catch((err) => {
                console.log(err.message);
            }
        );
    });
});