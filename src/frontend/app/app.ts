import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';

import {provide, Component} from 'angular2/core';
import {bootstrap, ELEMENT_PROBE_PROVIDERS} from 'angular2/platform/browser';
import {RouteConfig, ROUTER_PROVIDERS, ROUTER_DIRECTIVES} from 'angular2/router';

import {WelcomeComponent} from './component/welcome/WelcomeComponent';
import {SquareComponent} from './component/square/SquareComponent';

@Component({
    selector: 'cass-bootstrap',
    template: require('./app.html'),
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
@RouteConfig([
    {
        path: '/welcome',
        as: 'Welcome',
        component: WelcomeComponent,
    },
    {
        path: '/square/...',
        as: 'Square',
        component: SquareComponent,
        useAsDefault: true
    }
])
class App
{
}

document.addEventListener('DOMContentLoaded', () => {
    bootstrap(App, [
        ROUTER_PROVIDERS
    ]).catch((err) => {
        console.log(err.message);
    });
});