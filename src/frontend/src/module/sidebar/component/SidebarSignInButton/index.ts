import {Component, Directive} from "@angular/core";
import {AuthComponentService} from "../../../auth/component/Auth/service";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-sidebar-sign-in-button'})

export class SidebarSignInButton
{
    constructor(private service: AuthComponentService) {}
    
    click() {
        this.service.signIn();
    }
}