import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";

import {CommunityComponent} from "../../index";
import {CommunityPage} from "../CommunityPageRoute/index";
import {CommunityMenuComponent} from "../../component/Menu/index";

@Component({
    selector: "community-router",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        CommunityMenuComponent
    ]
})

@RouteConfig([
    {
        name: 'CommunityLanding',
        path: '/',
        component: CommunityComponent,
        useAsDefault: true
    },
    {
        name: 'CommunityPage',
        path: '/id/:sid',
        component: CommunityPage,
    }
])

export class CommunityRoute
{
}