import {Component} from "@angular/core";

import {ProfileRouteService} from "../ProfileRoute/service";
import {ProfileModals} from "../../component/Elements/Profile/modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCollectionsListRoute
{
    constructor(
        private service: ProfileRouteService,
        private modals: ProfileModals
    ) {}

    openCreateCollectionModal() {
        this.modals.createCollection.open();
    }
}