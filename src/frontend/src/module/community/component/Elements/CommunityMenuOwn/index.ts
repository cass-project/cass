import {Component} from "@angular/core";

import {CommunityModals} from "../Community/modals";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";

@Component({
    selector: 'cass-profile-menu-own',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileMenuOwn
{
    constructor(
        private service: CommunityRouteService,
        private modals: CommunityModals
    ) {}

    getCollections() {
        return this.service.getCollections().filter(collection => {
            return collection.is_main !== true;
        });
    }

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }

    openSettings() {
        this.modals.settings.open();
    }
}