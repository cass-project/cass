import {Component, Input} from "@angular/core";
import {CommunityComponent} from "../../../index";
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityComponent
    ],selector: 'cass-community-menu'})
export class communityMenuComponent
{
    @Input('community') community: CommunityExtendedEntity;
}