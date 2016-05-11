import {Component} from "angular2/core";

import {ProfileMenuComponent} from "./component/ProfileMenu/index";
import {RouterOutlet} from "angular2/router";
import {RouteConfig} from "angular2/router";
import {ProfileDashboardComponent} from "./page/Dashbord/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        ProfileMenuComponent,
    ]
})
@RouteConfig([
    {
        name: 'Dashboard',
        path: '/',
        component: ProfileDashboardComponent,
        useAsDefault: true
    }
])
export class ProfileComponent
{}