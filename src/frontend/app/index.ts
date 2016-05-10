/// <reference path="./../typings/main.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../node_modules/reset.css/reset.css');
require('./styles/index.scss');

import {bootstrap} from 'angular2/platform/browser';
import {Component, provide} from 'angular2/core';
import {ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {HTTP_PROVIDERS, BaseRequestOptions, RequestOptions} from 'angular2/http';
import {CORE_DIRECTIVES} from 'angular2/common';

import {AuthService} from './module/auth/service/AuthService';
import {frontline, FrontlineService} from "./module/frontline/service";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES
    ]
})
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