import {Component} from "@angular/core";
import {Session} from "../../../session/Session";
import {IMRESTService} from "../../../im/service/IMRESTService";
import {ProfileImage} from "../../../profile/component/Elements/ProfileImage/index";
import {IMUnreadResponseEntity} from "../../../im/definitions/paths/im-unread";

@Component({
    selector: 'cass-sidebar-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
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