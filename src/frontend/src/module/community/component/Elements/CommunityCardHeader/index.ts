import {Component, Input, EventEmitter, Output} from "@angular/core";

import {CommunityImage} from "../CommunityImage/index";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Router} from "@angular/router-deprecated";
import {CommunityEntity} from "../../../definitions/entity/Community";

var moment = require('moment');

@Component({
    selector: 'cass-community-card-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityImage,
    ]
})
export class CommunityCardHeader
{
    @Input('community') entity: CommunityEntity;
    @Input('time') time: Date;
    
    constructor(private router: Router) {}

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

    getCommunityLink(): string {
        return this.router.generate(['/CommunityRoot', 'Community', { 'id': this.entity.id }]).toLinkUrl();
    }

    goCommunity() {
        this.router.navigate(['/CommunityRoot', 'Community', { 'id': this.entity.id }]);
    }
}