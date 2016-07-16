import {Component} from "angular2/core";
import {CommunityModals} from "../../../modals";

@Component({
    selector: 'cass-community-create-collection-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCreateCollectionCard
{
    constructor(private modals: CommunityModals) {}

    openCreateCollectionMaster() {
        this.modals.createCollection.open();
    }
}