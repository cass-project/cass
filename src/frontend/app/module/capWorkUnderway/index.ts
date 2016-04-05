import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ServiceUnavailable} from './ServiceUnavailable/index'

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})

@RouteConfig([
    {
        useAsDefault: true,
        path: '/Service-Unavailable',
        name: 'Service-Unavailable',
        component: ServiceUnavailable
    }
])
export class WorkUnderway
{
}