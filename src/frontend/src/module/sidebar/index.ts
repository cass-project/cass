import {Component} from "angular2/core";

import {SidebarSignInButton} from "./component/SidebarSignInButton/index";
import {SidebarProfileIcon} from "./component/SidebarProfileIcon/index";
import {SidebarCommunities} from "./component/SidebarCommunities/index";
import {AuthService} from "../auth/service/AuthService";
import {SidebarMessages} from "./component/SidebarMessages/index";

require('./style.head.scss');

@Component({
    selector: 'cass-sidebar',
    template: require('./template.html'),
    directives: [
        SidebarSignInButton,
        SidebarProfileIcon,
        SidebarCommunities,
        SidebarMessages,
    ]
})
export class SidebarComponent
{
    constructor(private authService: AuthService) {}

    isSignedIn() {
        return this.authService.isSignedIn();
    }
}