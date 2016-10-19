import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CommunityEntity} from "../../../../../definitions/entity/Community";
import {CommunityCardHelper} from "../../helper";

@Component({
    selector: 'cass-community-card-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class CommunityCardList
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