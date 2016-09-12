import {Component, Input, Directive} from "@angular/core";

import {CommunityComponent} from "../../../index";
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityComponent
    ]
})
@Directive({selector: 'cass-community-menu'})
export class communityMenuComponent
{
    @Input('community') community: CommunityExtendedEntity;
}