import {Component, Input} from "angular2/core";

import {CommunityComponent} from "../../../index";
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

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