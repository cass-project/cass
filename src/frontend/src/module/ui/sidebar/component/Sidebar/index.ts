import {Component} from "@angular/core";
import {Router} from "@angular/router";

import {AuthService} from "../../../../auth/service/AuthService";
import {AuthModalsService} from "../../../../auth/component/Auth/modals";
import {UIService} from "../../../service/ui";
import {ProfileModals} from "../../../../profile/component/Elements/Profile/modals";

require('./style.head.scss');

@Component({
    selector: 'cass-sidebar',
    template: require('./template.jade'),
})
export class SidebarComponent
{
    constructor(
        private authService: AuthService,
        private authModals: AuthModalsService,
        private profileModals: ProfileModals,
        private uiService: UIService,
        private router: Router
    ) {}

    private isSignedIn() {
        return this.authService.isSignedIn();
    }

    private signIn() {
        this.authModals.signIn();
    }

    private signOut(){
        this.authModals.signOut();
    }

    private switchProfile() {
        this.profileModals.switcher.open();
    }

    private isSearchActive() {
        return this.uiService.panels.header.isEnabled();
    }

    private toggleSearch() {
        this.uiService.panels.header.toggle();
    }
}