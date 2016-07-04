import {Component} from "angular2/core";
import {Title} from "angular2/src/platform/browser/title";

import {AuthService}            from "../../../../../module/auth/service/AuthService";
import {AuthComponentService}   from "../../../../../module/auth/component/Auth/service";

@Component({
    selector: 'cass-feedback-access-denied',
    template: require('./template.jade')
})
export class AccessDeniedComponent {

    constructor(
        private authService:AuthService,
        private titleService: Title,
        private authComponentService: AuthComponentService
    ) {
        titleService.setTitle("AccessDenied");
    }
    
    showForm() {
        this.authComponentService.signIn();
    }
}