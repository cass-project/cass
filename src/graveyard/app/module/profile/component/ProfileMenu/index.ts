import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: 'profile-menu',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
export class ProfileMenu
{
    constructor() {
    }
    
    isCollectionManagerAvailable() {
        return true; 
    }
}