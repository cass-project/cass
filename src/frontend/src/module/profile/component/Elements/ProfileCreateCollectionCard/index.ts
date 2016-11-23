import {Component} from "@angular/core";

import {ProfileModals} from "../Profile/modals";

@Component({
    selector: 'cass-profile-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCreateCollectionCard
{
    constructor(private modals: ProfileModals) {}

    openCreateCollectionMaster() {
        this.modals.openCreateCollectionModal();
    }
}