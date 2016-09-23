import {Component} from "@angular/core";

import {ProfileRouteService} from "../ProfileRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCollectionsListRoute
{
    private collections: CollectionEntity[];

    constructor(
        private service: ProfileRouteService,
    ) {}

    ngOnInit() {
        this.collections = this.service.getProfile().collections;
    }

    openCreateCollectionModal() {
        this.service.modals.createCollection.open();
    }
}