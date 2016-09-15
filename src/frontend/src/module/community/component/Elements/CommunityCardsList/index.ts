import {Component, Input} from "@angular/core";
import {Router} from "@angular/router";
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