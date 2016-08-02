import {Component} from "angular2/core";

import {CollectionCard} from "../../../../collection/component/Elements/CollectionCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {CollectionIndexEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";

@Component({
    selector: 'cass-feed-collection-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CollectionCard,
        LoadingIndicator,
        FeedScrollDetector
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