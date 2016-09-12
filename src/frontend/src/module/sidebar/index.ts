import {Component, Directive} from "@angular/core";

import {SidebarSignInButton} from "./component/SidebarSignInButton/index";
import {SidebarProfileIcon} from "./component/SidebarProfileIcon/index";
import {SidebarCommunities} from "./component/SidebarCommunities/index";
import {AuthService} from "../auth/service/AuthService";
import {SidebarMessages} from "./component/SidebarMessages/index";

require('./style.head.scss');

@Component({
    template: require('./template.jade'),
})
@Directive({selector: 'cass-sidebar'})
export class SidebarComponent
{
    constructor(private authService: AuthService) {}

    isSignedIn() {
        return this.authService.isSignedIn();
    }
}