import {Component} from "@angular/core";
import {AuthService} from "../auth/service/AuthService";

require('./style.head.scss');

@Component({
    selector: 'cass-sidebar',
    template: require('./template.jade'),
})
export class SidebarComponent
{
    constructor(private authService: AuthService) {}

    isSignedIn() {
        return this.authService.isSignedIn();
    }
}