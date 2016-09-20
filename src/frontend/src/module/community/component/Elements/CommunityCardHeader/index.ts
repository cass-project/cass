import {Component, Input} from "@angular/core";
import {Router} from "@angular/router";

import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {CommunityEntity} from "../../../definitions/entity/Community";

var moment = require('moment');

@Component({
    selector: 'cass-community-card-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class CommunityCardHeader
{
    constructor(private router: Router) {}

    @Input('community') entity: CommunityEntity;
    @Input('time') time: Date;

    getTime(): string {
        return moment().format('MMMM Do YYYY, h:mm:ss a');
    }

    hasTime(): boolean {
        return this.time instanceof Date;
    }

    getCommunityTitle(): string {
        return this.entity.title;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.entity.image).public_path;
    }

    goCommunity() {
        this.router.navigate(['/Community', 'Community', { 'id': this.entity.id }]);
    }
}