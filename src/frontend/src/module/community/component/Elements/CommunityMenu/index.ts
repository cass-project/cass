import {Component, Input} from "@angular/core";

import {CommunityComponent} from "../../../index";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";

@Component({
    selector: 'cass-community-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityComponent
    ]
})
export class communityMenuComponent
{
    @Input('community') community: CommunityExtendedEntity;
}