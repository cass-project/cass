import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {RouteConfig} from "angular2/router";
import {CollectionAddComponent} from "./component/CollectionAdd/index";
import {CollectionHomeComponent} from "./component/CollectionHome/index";
import {CollectionManageComponent} from "./component/CollectionManage/index";
import {CollectionViewComponent} from "./component/CollectionView/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
@RouteConfig([
    {
        useAsDefault: true,
        name: 'Home',
        path: '/',
        component: CollectionHomeComponent,
    },
    {

        name: 'Add',
        path: '/add',
        component: CollectionAddComponent
    },
    {
        name: 'Manage',
        path: '/manage',
        component: CollectionManageComponent
    },
    {
        name: 'View',
        path: '/view',
        component: CollectionViewComponent
    }
])
export class CollectionComponent {}