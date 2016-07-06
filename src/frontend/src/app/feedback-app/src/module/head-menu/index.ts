import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

import {AuthService} from "../../../../../module/auth/service/AuthService";
import {Router} from "angular2/router";

@Component({
    selector: 'cass-feedback-landing-menu',
    template: require('./template.jade'),
    directives:[
        ROUTER_DIRECTIVES
    ]
})
export class HeadMenuComponent {
    
    constructor(
        private authService:AuthService,
        private router:Router
    ){}
    
    signOut() {
        this.authService.signOut().subscribe(()=>{
            this.router.navigate(["/FeedbackRoute", "AccessDenied"]);
        });
    }
}