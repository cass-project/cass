import {Component, Input, EventEmitter, Output, Directive} from "@angular/core";

import {CommunityImage} from "../CommunityImage/index";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Router} from '@angular/router';
import {CommunityEntity} from "../../../definitions/entity/Community";

var moment = require('moment');

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-community-card'})
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
    

    goCommunity() {
        this.router.navigate(['/Community', 'Community', { 'id': this.entity.id }]);
    }
}