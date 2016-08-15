import {Component} from "@angular/core";
import {RouterOutlet, RouteConfig} from "@angular/router-deprecated";

import {CommunityNotFoundRoute} from "../CommunityNotFoundRoute/index";
import {CommunityRoute} from "../CommunityRoute/index";
import {Nothing} from "../../../common/component/Nothing/index";

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
        name: 'Community',
        path: '/:sid/...',
        component: CommunityRoute
    },
    {
        name: 'NotFound',
        path: '/not-found',
        component: CommunityNotFoundRoute
    },
])
export class CommunityRootRoute
{
}