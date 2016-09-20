import {Component} from "@angular/core";
import {Router} from "@angular/router";

import {AuthService} from "../../../auth/service/AuthService";

require('./style.head.scss');

@Component({
    selector: 'cass-sidebar',
    template: require('./template.jade'),
})
export class SidebarComponent
{
    constructor(
        private authService: AuthService,
        private router: Router
    ) {}

    private isSignedIn() {
        return this.authService.isSignedIn();
    }

    private signOut(){
        this.authService.signOut().subscribe(() => {
            this.router.navigate(['home']);
        });
    }
}