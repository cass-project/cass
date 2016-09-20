import {Component} from "@angular/core";

import {CollectionIndexEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";

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
        private options: FeedOptionsService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}