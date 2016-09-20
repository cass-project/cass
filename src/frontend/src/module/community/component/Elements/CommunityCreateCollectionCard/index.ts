import {Component} from "@angular/core";

import {CurrentCommunityService} from "../../../route/CommunityRoute/service";

@Component({
    selector: 'cass-community-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCreateCollectionCard
{
    constructor(private service: CurrentCommunityService) {}

    openCreateCollectionMaster() {
        this.service.modals.createCollection.open();
    }
}