import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router-deprecated';

import {AuthService} from "../../../../../module/auth/service/AuthService";
import {Router} from '@angular/router-deprecated';

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