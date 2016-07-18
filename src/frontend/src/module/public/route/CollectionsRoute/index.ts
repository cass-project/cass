import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {PublicService} from "../../service";
import {NothingFound} from "../../component/Elements/NothingFound/index";
import {PublicCollectionsSource} from "../../../feed/service/FeedService/source/public/PublicCollectionsSource";
import {FeedCollectionStream} from "../../../feed/component/stream/FeedCollectionStream/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        PublicCollectionsSource,
    ],
    directives: [
        FeedCollectionStream,
        NothingFound,
    ]
})
export class CollectionsRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<PostEntity>,
        private source: PublicCollectionsSource
    ) {
        catalog.source = 'collections';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<PostEntity>());
        service.criteria = catalog.criteria;
        service.update();
    }
}