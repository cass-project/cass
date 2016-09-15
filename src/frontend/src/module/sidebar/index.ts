import {Component} from "@angular/core";
import {AuthService} from "../auth/service/AuthService";
import {Router} from "@angular/router";

require('./style.head.scss');

@Component({
    selector: 'cass-sidebar',
    template: require('./template.jade'),
})
export class SidebarComponent
{
    constructor(private authService: AuthService, private router: Router) {}

    isSignedIn() {
        return this.authService.isSignedIn();
    }

    signOut(){
        this.authService.signOut().subscribe(() => {
            this.router.navigate(['home']);
        });
    }
}