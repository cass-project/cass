import {Component} from "angular2/core";
import {ProfileIMService} from "../../../profile-im/service/ProfileIMService";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    selector: 'cass-sidebar-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        ROUTER_DIRECTIVES
    ]
})
export class SidebarMessages
{
    private isSwitchedMessages: boolean = true;

    isSwitched() {
        return this.isSwitchedMessages;
    }

    switchMessages() {
        this.isSwitchedMessages = !this.isSwitchedMessages;
    }
}