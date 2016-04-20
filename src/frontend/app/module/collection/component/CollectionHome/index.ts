import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig, Router} from "angular2/router";
import {WorkInProgress} from "../../../common/component/WorkInProgress/index";
import {AuthService} from "../../../auth/service/AuthService";


@Component({
    template: require('./template.html'),
    directives: [
        WorkInProgress,
        ROUTER_DIRECTIVES
    ],
})
export class CollectionHomeComponent {
    constructor(public router: Router){}

    ngOnInit(){
        if(!AuthService.getAuthToken().getCurrentProfile().entity.is_initialized){
            this.router.parent.navigate(['Profile/Welcome']);
        }
    }
}