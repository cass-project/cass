import {Component} from "angular2/core";
import {ProfileIMService} from "../../../profile-im/service/ProfileIMService";

@Component({
    selector: 'cass-sidebar-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarMessages
{
    constructor(im:ProfileIMService){
        im.getUnreadMessages().subscribe(
            data => {
                console.log(data);
            }
        )
    }
    private isSwitchedMessages: boolean = true;

    isSwitched() {
        return this.isSwitchedMessages;
    }

    switchMessages() {
        this.isSwitchedMessages = !this.isSwitchedMessages;
    }
}