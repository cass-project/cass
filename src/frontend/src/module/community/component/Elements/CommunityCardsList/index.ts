import {Component, Input} from "angular2/core";

import {CommunityCard} from "../CommunityCard/index";
import {CommunityInterestsCard} from "../CommunityInterestsCard/index";
import {CommunityCreateCollectionCard} from "../CommunityCreateCollectionCard/index";
import {ProfileSettingsCard} from "../CommunitySettingsCard/index";

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
        CommunityInterestsCard,
        CommunityCreateCollectionCard,
        ProfileSettingsCard,
    ]
})
export class CommunityCardsList
{
    @Input('community') entity: CommunityExtendedEntity;

    constructor(private router: Router) {}

    ngOnInit(){
        console.log(this.entity);
    }

    isOwnCommunity(): boolean {
        return this.entity.is_own;
    }

    goDashboard() {
        if(this.isOwnCommunity()){
            this.router.navigate(['/Community', { id: 'current' }, 'Dashboard']);
        } else {
            this.router.navigate(['/Community', {id: this.entity.community.id.toString()}, 'Dashboard']);
        }
    }
}