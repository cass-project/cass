import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CommunityEntity} from "../../../../../definitions/entity/community";
import {CommunityCardHelper} from "../../helper";

@Component({
    selector: 'cass-community-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CommunityCardGrid
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