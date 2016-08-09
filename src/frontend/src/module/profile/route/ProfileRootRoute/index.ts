import {Component} from "@angular/core";

import {RouterOutlet} from '@angular/router-deprecated';
import {RouteConfig} from "@angular/router-deprecated";
import {Nothing} from "../../../common/component/Nothing/index";
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
export class ProfileRootRoute
{
}