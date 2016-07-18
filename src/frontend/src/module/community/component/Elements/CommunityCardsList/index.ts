import {Component, Input} from "angular2/core";

import {CommunityCard} from "../CommunityCard/index";
import {CommunityCreateCollectionCard} from "../CommunityCreateCollectionCard/index";
import {CommunitySettingsCard} from "../CommunitySettingsCard/index";

import {Router} from "angular2/router";
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

@Component({
    selector: 'cass-community-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityCard,
        CommunityCreateCollectionCard,
        CommunitySettingsCard,
    ]
})
export class CommunityCardsList
{
    @Input('community') entity: CommunityExtendedEntity;

    constructor(private router: Router) {}

    isOwnCommunity(): boolean {
        return this.entity.is_own;
    }

    goDashboard() {
        this.router.navigate(['/Community', 'Community', {sid: this.entity.community.sid}, 'Dashboard']);
    }
}