import {Component, Input, Directive} from "@angular/core";

import {CommunityCard} from "../CommunityCard/index";
import {CommunityCreateCollectionCard} from "../CommunityCreateCollectionCard/index";
import {CommunitySettingsCard} from "../CommunitySettingsCard/index";

import {Router} from '@angular/router';
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-cards-list'})
export class CommunityCardsList
{
    @Input('community') entity: CommunityExtendedEntity;

    constructor(private router: Router) {}

    isOwnCommunity(): boolean {
        return this.entity.is_own;
    }
}