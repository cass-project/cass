import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: 'cass-feedback-landing-sidebar',
    template: require('./template.jade'),
    directives:[
        ROUTER_DIRECTIVES
    ]
})
export class SidebarComponent {}