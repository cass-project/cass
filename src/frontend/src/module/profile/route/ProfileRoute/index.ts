import {Component} from "angular2/core";

import {RouterOutlet, RouteConfig} from "angular2/router";
import {ModalComponent} from "../../../modal/component/index";
import {ProfileMenuComponent} from "../../component/ProfileMenu/index";
import {ProfileModal} from "../../component/ProfileModal/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {Nothing} from "../../../util/component/Nothing/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        ModalComponent,
        ModalBoxComponent,
        ProfileMenuComponent,
        ProfileModal,
    ]
})
@RouteConfig([
    {
        name: 'Dashboard',
        path: '/',
        component: Nothing,
        useAsDefault: true
    }
])
export class ProfileRoute
{
}