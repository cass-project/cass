import {Component, Output, EventEmitter} from "angular2/core";
import {RouteConfig, RouterOutlet, ROUTER_DIRECTIVES, ROUTER_PROVIDERS, RouteParams, Router} from "angular2/router";

import {Screen} from "../../screen";
import {CommunityCreateModalModel} from "../../model";

@Component({
    selector: 'cass-community-create-modal-screen-complete',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenComplete
{
    @Output("close") abortEvent = new EventEmitter<ScreenComplete>();

    constructor(private router: Router, protected model: CommunityCreateModalModel){
    }

    close() {
        this.abortEvent.emit(this);
    }

    goToCommunity() {
        console.log(this.model);
        //this.router.navigateByUrl('/community/community-settings-modal-demo');
    }

}