import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from 'angular2/router'

@Component({
    selector: "cass-main-menu-collection",
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class MainMenuCollections
{
}