import {Component} from "@angular/core";

import {AuthService} from "../../../auth/service/AuthService";
import {ProfileModals} from "../../../profile/modals";
import {Router} from '@angular/router';

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
    
    constructor(
        private authService: AuthService,
        private modals: ProfileModals,
        private router: Router
    ) {}

    goToProfile() {
        this.router.navigate(['/profile', 'current' ]);
    }

    openProfileSettings() {
        this.modals.settings.open();
    }

    openProfileSwitcher() {
        this.modals.switcher.open();
    }

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