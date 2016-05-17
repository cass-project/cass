import {SidebarMessages} from "./component/SidebarMessages/index";
require('./style.head.scss');

import {Component} from "angular2/core";

import {SidebarSignInButton} from "./component/SidebarSignInButton/index";
import {SidebarProfileIcon} from "./component/SidebarProfileIcon/index";
import {SidebarCommunities} from "./component/SidebarCommunities/index";

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
}