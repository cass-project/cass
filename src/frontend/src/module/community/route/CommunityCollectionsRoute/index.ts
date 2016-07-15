import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {ProfileCollectionsListRoute} from "../CommunityCollectionsListRoute/index";
import {ProfileCollectionRoute} from "../CommunityCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "../CommunityCollectionNotFoundRoute/index";

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