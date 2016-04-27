import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {ViewCollection} from "./component/ViewCollection/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
@RouteConfig([
    {
        name: 'View',
        path: '/view/:collectionId',
        component: ViewCollection
    }
])
export class CollectionComponent {} 