import {Component} from "angular2/core";
import {AuthComponentService} from "../../auth/component/Auth/service";

@Component({
    selector: 'cass-sidebar',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
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

    signOut() {
        this.authComponentService.modals.openSignOutModal();
    }
}