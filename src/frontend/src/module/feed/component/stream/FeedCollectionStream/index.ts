import {Component} from "@angular/core";

import {CollectionIndexEntity, CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {CollectionService} from "../../../../collection/service/CollectionService";

@Component({
    selector: 'cass-feed-collection-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedCollectionStream
{
    constructor(
        private feed: FeedService<CollectionIndexEntity>,
        private options: FeedOptionsService,
        private collection: CollectionService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }

    open($event: CollectionEntity) {
        this.collection.navigateCollection($event);
    }
}