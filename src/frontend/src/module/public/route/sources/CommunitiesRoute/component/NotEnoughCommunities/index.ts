import {Component} from "@angular/core";

import {CommunityModalService} from "../../../../../../community/service/CommunityModalService";

@Component({
    selector: 'cass-public-not-enough-communities',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class NotEnoughCommunities
{
    constructor(
        private modals: CommunityModalService
    ) {}

    createCommunity() {
        this.modals.create.open();
    }
}