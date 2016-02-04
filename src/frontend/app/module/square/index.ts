import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';

import {SquareHomeComponent} from './component/SquareHomeComponent/component';
import {SquareCalculateComponent} from './component/SquareCalculateComponent/component';

@Component({
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES],
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
export class SquareComponent
{
}