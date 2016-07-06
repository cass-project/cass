import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {SearchService} from "./search/SearchService";
import {SearchRoute} from "./route/SearchRoute/index";
import {SearchCriteriaService} from "./search/SearchCriteriaService";

@Component({
    selector: 'cass-public',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        SearchService,
        SearchCriteriaService,
    ],
    directives: [
        ROUTER_DIRECTIVES
    ]
})
@RouteConfig([
    {
        path: '/',
        name: 'Search',
        component: SearchRoute,
        useAsDefault: true
    }
])
export class PublicComponent
{
}