import {Component} from "angular2/core";

import {RouterOutlet, RouteConfig, Router} from "angular2/router";
import {Nothing} from "../../../util/component/Nothing/index";
import {ProfileRoute} from "../ProfileRoute/index";
import {ProfileNotFoundRoute} from "../ProfileNotFoundRoute/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
    ],
})
@RouteConfig([
    {
        name: 'Root',
        path: '/',
        component: Nothing,
        useAsDefault: true
    },
    {
        name: 'Profile',
        path: '/:id/...',
        component: ProfileRoute
    },
    {
        name: 'NotFound',
        path: '/not-found',
        component: ProfileNotFoundRoute
    },
])
export class RootRoute
{
}