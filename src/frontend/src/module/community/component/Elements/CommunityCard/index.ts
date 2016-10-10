import {Component, Input, OnChanges} from "@angular/core";

import {CommunityEntity} from "../../../definitions/entity/Community";
import {CommunityCardHelper} from "./helper";

@Component({
    selector: 'cass-community-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class CommunityCard implements OnChanges
{
    @Input('community') community: CommunityEntity;

    constructor(
        private helper: CommunityCardHelper
    ) {}

    ngOnChanges() {
        this.helper.setCommunity(this.community);
    }
}