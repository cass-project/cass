import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';

require('zone.js');
require('reset-css/reset.css');
require('./global.head.scss');

import {Component} from 'angular2/core';
import {bootstrap} from 'angular2/platform/browser';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';

import {WelcomeComponent} from './module/welcome/index';
import {SquareComponent} from './module/square/index';
import {AuthComponent} from './module/auth/index';


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
    }
])
class App
{
}

document.addEventListener('DOMContentLoaded', () => {
    bootstrap(
        App, [
        ROUTER_PROVIDERS
    ]).catch((err) => {
        console.log(err.message);
    });
});