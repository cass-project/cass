import {Component} from "@angular/core";

import {CurrentCommunityService} from "../CommunityRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCollectionsListRoute
{
    constructor(private service: CurrentCommunityService) {}

    openCreateCollectionModal($event) {
        this.service.modals.createCollection.open();
    }
}