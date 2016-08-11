import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from "@angular/router-deprecated";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {CommunityService} from "../../service/CommunityService";
import {CommunityModalService} from "../../service/CommunityModalService";

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
export class CommunityCollectionsListRoute
{
    constructor(private communityService: CommunityService, private communityModalService: CommunityModalService) {
    }

    openCreateCollectionModal() {
        this.communityModalService.createCollection.open();
    }
}