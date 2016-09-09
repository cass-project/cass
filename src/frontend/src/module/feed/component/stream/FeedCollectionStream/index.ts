import {Component} from "@angular/core";

import {CollectionCard} from "../../../../collection/component/Elements/CollectionCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {CollectionIndexEntity} from "../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
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