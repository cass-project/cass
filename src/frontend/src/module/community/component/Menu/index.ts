import {Component} from "@angular/core";

import {CurrentCommunityService} from "../../route/CommunityRoute/service";

@Component({
    selector: 'cass-community-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityMenuComponent
{
    constructor(
        private current: CurrentCommunityService,
    ) {}

    isAdmin() {
        let community = this.current.getCommunity();

        if(community) {
            return this.current.getCommunity().is_own;
        }else{
            return false;
        }
    }

    openSettings() {
        this.current.modals.settings.open();
    }
}