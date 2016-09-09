import {Component} from "@angular/core";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {CommunityRouteService} from "../CommunityRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCollectionsListRoute
{
    constructor(private service: CommunityRouteService) {}

    openCreateCollectionModal($event) {
        this.service.modals.createCollection.open();
    }
}