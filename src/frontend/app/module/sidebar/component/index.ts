import {Component} from "angular2/core";
import {AuthComponentService} from "../../auth/component/Auth/service";
import {SidebarItemComponent} from "../item/index";

@Component({
    selector: 'cass-sidebar',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        SidebarItemComponent
    ]
})
export class SidebarComponent
{
    constructor(private authComponentService: AuthComponentService) {}

    signIn() {
        this.authComponentService.modals.openSignInModal();
    }

    signUp() {
        this.authComponentService.modals.openSignUpModal();
    }
}