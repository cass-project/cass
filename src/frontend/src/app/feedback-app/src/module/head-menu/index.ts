import {Component} from "angular2/core";

import {AuthService} from "../../../../../module/auth/service/AuthService";
import {Router} from "angular2/router";
import {AuthComponentService} from "../../../../../module/auth/component/Auth/service";

@Component({
    selector: 'cass-feedback-landing-menu',
    template: require('./template.jade')
})
export class HeadMenuComponent {
    
    constructor(
        private authService:AuthService,
        private authComponentService:AuthComponentService,
        private router:Router
    ){}
    
    signOut() {
        this.authService.signOut().subscribe(()=>{
            this.router.navigate(["/FeedbackRoute", "AccessDenied"]);
        });
    }
    
    click() {
        this.authComponentService.signIn();
    }
}