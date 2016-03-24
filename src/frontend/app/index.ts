/// <reference path="./../typings/main.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');
require('bootstrap/dist/css/bootstrap.css');
require('./global.head.scss');

import {Component, provide} from 'angular2/core';
import {bootstrap} from 'angular2/platform/browser';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {HTTP_PROVIDERS, BaseRequestOptions, RequestOptions, URLSearchParams} from 'angular2/http';
import {Cookie} from 'ng2-cookies';

import {MainMenu} from './module/main/component/MainMenu/index'
import {AuthService} from './module/auth/service/AuthService';
import {HeaderNavComponent} from './module/main/component/HeaderNavComponent/index';

import {AuthComponent} from './module/auth/index';
import {ProfileComponent} from './module/profile/index';
import {CatalogComponent} from './module/catalog/index';
import {ThemeEditorComponent} from './module/host-admin/component/ThemeEditorComponent/component';

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        MainMenu,
        HeaderNavComponent
    ],
    providers: [
        AuthService
    ]
})
@RouteConfig([
    {
        path: '/auth/...',
        name: 'Auth',
        component: AuthComponent
    },
    {
        path: '/profile/...',
        name: 'Profile',
        component: ProfileComponent,
        useAsDefault: true
    },
    {
        path: '/catalog/',
        name: 'Catalog',
        component: CatalogComponent
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

        this.headers.append('Content-type', 'application/json');

        if(Cookie.getCookie('api_key')) {
            this.headers.set('X-Api-Key', Cookie.getCookie('api_key'));
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
