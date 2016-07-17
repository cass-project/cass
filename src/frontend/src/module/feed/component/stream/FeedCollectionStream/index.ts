import {Component} from "angular2/core";

import {CollectionCard} from "../../../../collection/component/Elements/CollectionCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";

@Component({
    selector: 'cass-feed-collection-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CollectionCard,
        LoadingIndicator,
    ]
})
export class FeedCollectionStream
{
    constructor(private feed: FeedService<CollectionEntity>) {}

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}