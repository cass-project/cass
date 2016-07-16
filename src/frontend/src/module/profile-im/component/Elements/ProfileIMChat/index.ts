import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams, ROUTER_DIRECTIVES} from "angular2/router";

import {ProfileIMService}          from "../../../service/ProfileIMService";
import {ProfileIMChatHistory}      from "../ProfileIMChatHistory/index";
import {ProfileIMTextarea}         from "../ProfileIMTextarea/index";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProfileIMTextarea,
        ProfileIMChatHistory
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;
    isNeedScroll = false;

    constructor(private params: RouteParams, private im:ProfileIMService) {
        im.loadHistory(parseInt(params.get('id')), 0, 10, false)
            .subscribe(() => this.isNeedScroll = true);
        
        im.createStream()
            .subscribe(() => this.isNeedScroll = true);
    }
    
    ngAfterViewChecked() {
        if(this.isNeedScroll) this.scroll();
    }
    
    scroll() {
        this.isNeedScroll = false;
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }
}
