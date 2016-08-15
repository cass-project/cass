import {Component} from "@angular/core";

import {CommunityModalService} from "../../../service/CommunityModalService";

@Component({
    selector: 'cass-community-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCreateCollectionCard
{
    constructor(private modals: CommunityModalService) {}

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }
}