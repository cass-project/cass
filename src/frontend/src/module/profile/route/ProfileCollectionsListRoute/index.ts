import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router-deprecated';

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
    ]
})
export class ProfileCollectionsListRoute
{
    constructor(private service: ProfileRouteService) {}
    
    openCreateCollectionModal() {
        this.service.modals.createCollection.open();
    }
}