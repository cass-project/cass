import {Component} from "angular2/core";

import {AuthService} from "../../../auth/service/AuthService";

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

    getImageProfile(){
        if(AuthService.isSignedIn()){
            return AuthService.getAuthToken().getCurrentProfile().entity.profile.image.variants['default'].public_path;
        }
    }

    switchProfileMenu() {
        this.isProfileMenuSwitched = !this.isProfileMenuSwitched;
    }

    isSwitched() {
        return this.isProfileMenuSwitched;
    }
}