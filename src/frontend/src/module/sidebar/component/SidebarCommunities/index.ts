import {Component} from "angular2/core";

import {CommunityModalService} from "../../../community/service/CommunityModalService";
import {Router, ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: 'cass-sidebar-communities',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
export class SidebarCommunities
{
    private isSwitchedCommunityBookmarks: boolean = true;

    constructor(
        private router: Router,
        private communityModalService: CommunityModalService
    ) {}

    isSwitched() {
        return this.isSwitchedCommunityBookmarks;
    }

    switchCommunityBookmarks() {
        this.isSwitchedCommunityBookmarks = !this.isSwitchedCommunityBookmarks;
    }

    openCommunityModal() {
        this.communityModalService.modals.route.open();
    }
}