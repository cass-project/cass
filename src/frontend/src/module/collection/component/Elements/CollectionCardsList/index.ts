import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CollectionEntity} from "../../../definitions/entity/collection";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-collection-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionCardsList
{
    @Input('entities') entities: CollectionEntity[] = [];
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    open($event: CollectionEntity) {
        this.openEvent.emit($event);
    }
}