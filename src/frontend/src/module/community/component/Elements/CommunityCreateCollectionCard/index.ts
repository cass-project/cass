import {Component} from "@angular/core";
import {CommunityModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-create-collection-card'})
export class CommunityCreateCollectionCard
{
    constructor(private modals: CommunityModals) {}

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }
}