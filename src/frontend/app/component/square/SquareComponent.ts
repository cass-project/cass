import {Component} from 'angular2/core';
import {RouteConfig, RouterOutlet, ROUTER_DIRECTIVES} from 'angular2/router';

import {SquareHomeComponent} from './home/SquareHomeComponent';
import {SquareCalculateComponent} from './calculate/SquareCalculateComponent';

@Component({
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES]
})
@RouteConfig([
    {
        path: '/',
        name: 'Home',
        component: SquareHomeComponent,
        useAsDefault: true
    },
    {
        path: '/calculate',
        name: 'Calculate',
        component: SquareCalculateComponent
    }
])
export class SquareComponent {
    constructor() {}
}