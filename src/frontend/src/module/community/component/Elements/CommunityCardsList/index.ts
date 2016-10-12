import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {CommunityEntity} from "../../../definitions/entity/Community";

@Component({
    selector: 'cass-community-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class CommunityCardsList
{
    @Input('entities') entities: CommunityEntity[];
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<CommunityEntity> = new EventEmitter<CommunityEntity>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    open($event: CommunityEntity) {
        this.openEvent.emit($event);
    }
}