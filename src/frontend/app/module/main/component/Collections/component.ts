import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {RouterCleaner} from "../../../routerCleaner/component";
import {CollectionsAdd} from "./CollectionsAdd/component";
import {CollectionsManage} from "./CollectionsManage/component";

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
    },
    {
        path: '/add',
        name: 'Collections-Add',
        component: CollectionsAdd
    },
    {
        path: '/manage',
        name: 'Collections-Manage',
        component: CollectionsManage
    }
])

export class Collections {

}
