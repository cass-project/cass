import {Component} from "angular2/core";

@Component({
    selector: 'cass-sidebar-messages',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
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