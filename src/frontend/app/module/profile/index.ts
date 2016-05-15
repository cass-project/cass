import {Component} from "angular2/core";

import {ProfileMenuComponent} from "./component/ProfileMenu/index";
import {RouterOutlet} from "angular2/router";
import {RouteConfig} from "angular2/router";
import {ProfileDashboardComponent} from "./page/Dashbord/index";
import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        ModalComponent,
        ProfileMenuComponent,
        ProfileModal,
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
{
}