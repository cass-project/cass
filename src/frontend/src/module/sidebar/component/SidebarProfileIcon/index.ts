import {Component} from "angular2/core";

import {AuthService} from "../../../auth/service/AuthService";
import {ProfileModals} from "../../../profile/modals";

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
    
    constructor(private authService: AuthService, private modals: ProfileModals) {}

    getImageProfile(){
        if(this.authService.isSignedIn()){
            return this.authService.getCurrentAccount().getCurrentProfile().entity.profile.image.variants['default'].public_path;
        }
    }

    switchProfileMenu() {
        this.isProfileMenuSwitched = !this.isProfileMenuSwitched;
    }

    isSwitched() {
        return this.isProfileMenuSwitched;
    }
}