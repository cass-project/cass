require('./stylesheets/main.scss');

import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {SquareComponent} from './component/square/SquareComponent';

@Component({
    selector: 'app',
    template: require('./app.html')
})
@RouteConfig([
    {
        path: '/square/calculate/',
        name: 'SquareCalculate',
        component: SquareComponent
    }
])
export class App
{
}