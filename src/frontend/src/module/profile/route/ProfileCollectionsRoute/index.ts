import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router-deprecated';
import {RouteConfig} from "@angular/router-deprecated";

import {ProfileCollectionsListRoute} from "../ProfileCollectionsListRoute/index";
import {ProfileCollectionRoute} from "../ProfileCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "../ProfileCollectionNotFoundRoute/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
@RouteConfig([
    {
        path: '/',
        name: 'List',
        component: ProfileCollectionsListRoute,
        useAsDefault: true
    },
    {
        path: '/not-found',
        name: 'NotFound',
        component: ProfileCollectionNotFoundRoute
    },
    {
        path: '/:sid',
        name: 'View',
        component: ProfileCollectionRoute
    },
])
export class ProfileCollectionsRoute
{

}