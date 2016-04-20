import {Component} from 'angular2/core';
import {AuthService} from "../../../auth/service/AuthService";
import {ROUTER_DIRECTIVES, RouteConfig, Router} from "angular2/router";

@Component({
    template: require('./template.html'),
    directives: []
})
export class ProfileDashboardComponent {

    constructor(public router:Router) {
    }

    ngOnInit() {
        if (!AuthService.getAuthToken().getCurrentProfile().entity.is_initialized) {
            this.router.parent.navigate(['Welcome']);
        }
    }
}