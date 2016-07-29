import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {Session} from "../../../session/Session";
import {IMRESTService} from "../../../im/service/IMRESTService";
import {ProfileImage} from "../../../profile/component/Elements/ProfileImage/index";
import {IMUnreadResponseEntity} from "../../../im/definitions/paths/im-unread";

@Component({
    selector: 'cass-sidebar-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        ROUTER_DIRECTIVES,
        ProfileImage
    ]
})

export class SidebarMessages
{
    private barVisiblityState: boolean = true;
    private isLoading: boolean = true;
    private unread: IMUnreadResponseEntity[] = [];
    
    constructor(private session: Session, private service: IMRESTService) {
        if(session.isSignedIn()) {
            this.checkUnread();
        }
    }

    checkUnread() {
        this.service
            .unreadInfo(this.session.getCurrentProfile().getId())
            .subscribe(data => {
                this.isLoading = false;
                this.unread = data.unread;
                setTimeout(()=> this.checkUnread(), 5000);
            });
    }

    toggleVisibility() {
        this.barVisiblityState = !this.barVisiblityState;
    }

    isBarVisible() : boolean {
        return this.barVisiblityState && !this.isLoading;
    }
}