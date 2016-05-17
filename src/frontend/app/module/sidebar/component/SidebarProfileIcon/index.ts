import {Component} from "angular2/core";

import {ProfileComponentService} from "../../../profile/service";

@Component({
    selector: 'cass-sidebar-profile-icon',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarProfileIcon
{
    private isProfileMenuSwitched: boolean = false;

    constructor(private service: ProfileComponentService) {}
    
    switchProfileMenu() {
        this.isProfileMenuSwitched = !this.isProfileMenuSwitched;
    }

    isSwitched() {
        return this.isProfileMenuSwitched;
    }
}