import {Component} from "@angular/core";
import {AuthComponentService} from "../../../auth/component/Auth/service";

@Component({
    selector: 'cass-sidebar-sign-in-button',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarSignInButton
{
    constructor(private service: AuthComponentService) {}
    
    click() {
        this.service.signIn();
    }
}