import {Component} from "@angular/core";
import {Router} from "@angular/router";

import {AuthService} from "../../../auth/service/AuthService";
import {AuthModalsService} from "../../../auth/component/Auth/modals";

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

    private isSearchActive() {
        return false;
    }

    private openSearchModal() {

    }
}