import {Component, Directive} from "@angular/core";
import {ProfileModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-profile-create-collection-card'})

export class ProfileCreateCollectionCard
{
    constructor(private modals: ProfileModals) {}

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }
}