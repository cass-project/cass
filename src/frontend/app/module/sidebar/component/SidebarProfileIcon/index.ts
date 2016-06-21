import {Component} from "angular2/core";

import {ProfileComponentService} from "../../../profile/service";
import {FrontlineService} from "../../../frontline/service";
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

    constructor(private service: ProfileComponentService, private frontlineService: FrontlineService ) {}

    getImageProfile(){
        if(AuthService.isSignedIn()){
            return AuthService.getAuthToken().getCurrentProfile().entity.image.variants['default'];
        }
    }

    switchProfileMenu() {
        this.isProfileMenuSwitched = !this.isProfileMenuSwitched;
    }

    isSwitched() {
        return this.isProfileMenuSwitched;
    }


}