import {Component} from "@angular/core";

import {CommunityRouteService} from "../../../route/CommunityRoute/service";
import {CommunityModals} from "../Community/modals";

@Component({
    selector: 'cass-community-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCreateCollectionCard
{
    constructor(private service: CommunityRouteService,
                private modals: CommunityModals
    ) {}

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }
}