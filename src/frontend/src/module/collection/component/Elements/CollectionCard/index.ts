import {Component, Input, Output, OnChanges, EventEmitter} from "@angular/core";

import {CollectionEntity} from "../../../definitions/entity/collection";
import {CollectionCardHelper} from "./helper";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {CollectionCardFeed} from "./view-modes/CollectionCardFeed/index";
import {CollectionCardList} from "./view-modes/CollectionCardList/index";
import {CollectionCardGrid} from "./view-modes/CollectionCardGrid/index";

@Component({
    selector: 'cass-collection-card',
    template: require('./template.jade'),
    providers: [
        CollectionCardHelper,
    ]
})

export class CollectionCard implements OnChanges
{
    @Input('entity') entity: CollectionEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();

    constructor(
        private helper: CollectionCardHelper
    ) {}

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    ngOnChanges() {
        this.helper.setCollection(this.entity);
    }

    open($event: CollectionEntity) {
        this.openEvent.emit($event);
    }
}

export const COLLECTION_CARD_DIRECTIVES = [
    CollectionCard,
    CollectionCardFeed,
    CollectionCardList,
    CollectionCardGrid,
];