import {Component, ViewEncapsulation} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router} from 'angular2/router'
import {AuthService} from '../../../auth/service/AuthService';
import {MainMenuSignInItem} from "./items/sign-in/index";
import {MainMenuProfileItem} from "./items/profile/index";
import {MainMenuSignOutItem} from "./items/sign-out/index";
import {MainMenuBrowseItem} from "./items/browse/index";

@Component({
    selector: 'cass-main-menu',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        MainMenuSignInItem,
        MainMenuProfileItem,
        MainMenuBrowseItem,
        MainMenuSignOutItem
    ],
    styles: [
        require('./style.shadow.scss')
    ],
    encapsulation: ViewEncapsulation.None
})
export class MainMenu
{
    isSignedIn() {
        return AuthService.isSignedIn();
    }
}