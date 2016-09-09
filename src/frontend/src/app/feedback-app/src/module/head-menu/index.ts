import {Component} from "@angular/core";

import {AuthService} from "../../../../../module/auth/service/AuthService";
import {Router} from '@angular/router';

@Component({
    selector: 'cass-feedback-landing-menu',
    template: require('./template.jade')
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