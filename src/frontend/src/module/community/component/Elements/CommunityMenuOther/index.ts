import {Component} from "@angular/core";

import {CommunityRouteService} from "../../../route/CommunityRoute/service";

@Component({
    selector: 'cass-profile-menu-other',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileMenuOther
{
    constructor(private service: CommunityRouteService) {}

    getCollections() {
        return this.service.getCollections().filter(collection => {
            return collection.is_main !== true;
        });
    }

    hasCollections() {
        return this.service.getCollections().filter(collection => {
                return collection.is_main !== true;
            }).length > 0;
    }
}