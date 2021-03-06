import {Component} from "@angular/core";

import {ProfileRouteService} from "../../../route/ProfileRoute/service";
import {ProfileModals} from "../Profile/modals";

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
        private service: ProfileRouteService,
        private modals: ProfileModals
    ) {}

    getCollections() {
        return this.service.getCollections().filter(collection => {
            return collection.is_main !== true;
        });
    }

    openCreateCollectionMaster() {
        this.modals.openCreateCollectionModal();
    }

    openSettings() {
        this.modals.settings.open();
    }
}