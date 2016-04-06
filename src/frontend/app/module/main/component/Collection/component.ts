import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {RouterCleaner} from "../../../routerCleaner/component";

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
        path: '/',
        name: 'RouterCleaner',
        component: RouterCleaner
    }
    ])

export class Collection {
}
