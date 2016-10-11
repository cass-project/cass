import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CommunityCardHelper} from "../../helper";
import {CommunityEntity} from "../../../../../definitions/entity/Community";

@Component({
    selector: 'cass-community-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CommunityCardFeed
{
    @Input('community') community: CommunityEntity;
    @Output('open') openEvent: EventEmitter<CommunityEntity> = new EventEmitter<CommunityEntity>();
    
    constructor(
        private helper: CommunityCardHelper
    ) {}

    open($event) {
        this.openEvent.emit(this.community);
    }
}