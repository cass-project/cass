import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";
import {CommunityPage} from "../../component/Page/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet
    ]
})
@RouteConfig([
    {
        name: 'CommunityPage',
        path: '/id/:sid',
        component: CommunityPage,
        useAsDefault: true
    }
])
export class CommunityRoute
{
}