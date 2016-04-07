import {Component} from 'angular2/core';
import {WorkInProgress} from "../common/component/WorkInProgress/index";
import {RouteConfig} from "angular2/router";
import {CatalogHomeComponent} from "./component/CatalogHome/index";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        WorkInProgress
    ],
})
@RouteConfig([
    {
        useAsDefault: true,
        name: 'Home',
        path: '/',
        component: CatalogHomeComponent
    }
])
export class CatalogComponent {}