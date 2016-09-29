import {Component} from "@angular/core";

import {CommunityRouteService} from "../CommunityRoute/service";
import {CommunityModals} from "../../component/Elements/Community/modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCollectionsListRoute
{
    constructor(private service: CommunityRouteService,
                private modals: CommunityModals
    ) {}

    openCreateCollectionModal($event) {
        this.modals.createCollection.open();
    }
}