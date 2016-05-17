import {Component} from "angular2/core";

import {RouterOutlet} from "angular2/router";
import {RouteConfig} from "angular2/router";
import {ModalComponent} from "../../../modal/component/index";
import {ProfileMenuComponent} from "../../component/ProfileMenu/index";
import {ProfileModal} from "../../component/ProfileModal/index";
import {ProfileDashboardRoute} from "../ProfileDashboardRoute/index";

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
        component: ProfileDashboardRoute,
        useAsDefault: true
    }
])
export class ProfileRoute
{
}