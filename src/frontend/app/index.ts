/// <reference path="./../typings/tsd.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');
require('./global.head.scss');

import {Component, provide} from 'angular2/core';
import {bootstrap} from 'angular2/platform/browser';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {HTTP_PROVIDERS, BaseRequestOptions, RequestOptions, URLSearchParams} from 'angular2/http';

import {WelcomeComponent} from './module/welcome/index';
import {SquareComponent} from './module/square/index';
import {AuthComponent} from './module/auth/index';
import {ThemeEditorComponent} from './module/host-admin/component/ThemeEditorComponent/component';


@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
@RouteConfig([
    {
        path: '/welcome',
        name: 'Welcome',
        component: WelcomeComponent,
        useAsDefault: true
    },
    {
        path: '/square/...',
        name: 'Square',
        component: SquareComponent,
    },
    {
        path: '/auth/...',
        name: 'Auth',
        component: AuthComponent
    },
    {
        path: '/theme-editor/...',
        name: 'Theme-Editor',
        component: ThemeEditorComponent
    }
])
class App
{
}

class OAuthRequestOptions extends BaseRequestOptions {
    constructor () {
        super();
        if(localStorage['account_token']){
            this.headers.set('Account-Token', localStorage['account_token']);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    bootstrap(
        <any>App, [
        ROUTER_PROVIDERS,
        HTTP_PROVIDERS,
        provide(RequestOptions, {useClass: OAuthRequestOptions})
    ]).catch((err) => {
        console.log(err.message);
    });
});
