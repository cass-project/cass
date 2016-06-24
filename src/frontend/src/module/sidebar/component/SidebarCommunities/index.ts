import {Component} from "angular2/core";

import {CommunityModalService} from "../../../community/service/CommunityModalService";

@Component({
    selector: 'cass-sidebar-communities',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarCommunities
{
    private isSwitchedCommunityBookmarks: boolean = true;

    constructor(
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