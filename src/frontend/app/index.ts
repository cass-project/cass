/// <reference path="./../typings/main.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';
import {Aggregator} from "./module/main/component/Aggregator/component";

require('zone.js');
require('bootstrap/dist/css/bootstrap.css');
require('./global.head.scss');

import {Component, provide} from 'angular2/core';
import {bootstrap} from 'angular2/platform/browser';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {HTTP_PROVIDERS, BaseRequestOptions, RequestOptions, URLSearchParams} from 'angular2/http';
import {CORE_DIRECTIVES} from 'angular2/common';
import {Cookie} from 'ng2-cookies';

import {MainMenu} from './module/main/component/MainMenu/index'
import {AuthService} from './module/auth/service/AuthService';
import {CurrentProfileService} from './module/profile/service/CurrentProfileService';
import {WorkUnderway} from './module/capWorkUnderway/index'
import {AuthComponent} from './module/auth/index';
import {ProfileComponent} from './module/profile/index';
import {CatalogComponent} from './module/catalog/index';
import {ThemeEditorComponent} from './module/host-admin/component/ThemeEditorComponent/component';
import {Collections} from "./module/main/component/Collections/component";
import {Collection} from "./module/main/component/Collection/component";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        MainMenu,
    ],
    providers: [
        AuthService,
        CurrentProfileService
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
        path: '/collections/...',
        name: 'Collections',
        component: Collections
    },
    {
        path: '/collection/...',
        name: 'Collection',
        component: Collection
    },
    {
        path: '/aggregator/...',
        name: 'Aggregator',
        component: Aggregator
    },
    {
        path: '/theme-editor/...',
        name: 'Theme-Editor',
        component: ThemeEditorComponent
    },
    {
        path: '/working/...',
        name: 'Working',
        component: WorkUnderway
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
        }
    );
});