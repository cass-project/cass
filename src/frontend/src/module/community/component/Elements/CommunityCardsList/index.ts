import {Component, Input} from "@angular/core";
import {Router} from "@angular/router";

import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";

@Component({
    selector: 'cass-community-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class CommunityCardsList
{
    @Input('community') entity: CommunityExtendedEntity;

    constructor(private router: Router) {}

    isOwnCommunity(): boolean {
        return this.entity.is_own;
    }
    
    goDashboard(){
        this.router.navigate(['/community', this.entity.community.sid]);
    }
}