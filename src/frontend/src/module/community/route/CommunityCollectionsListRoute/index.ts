import {Component} from "@angular/core";
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