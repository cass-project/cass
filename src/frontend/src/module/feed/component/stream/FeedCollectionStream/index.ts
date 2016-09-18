import {Component} from "@angular/core";
import {CollectionIndexEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {AppService} from "../../../../../app/frontend-app/service";

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
        private appService: AppService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        if(!this.feed.isLoading()){
            this.appService.onScroll(true);
        }
        return typeof this.feed.stream === "object";
    }
}