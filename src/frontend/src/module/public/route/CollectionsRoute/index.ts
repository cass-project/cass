import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {PublicCollectionsSource} from "../../../feed/service/FeedService/source/public/PublicCollectionsSource";
import {CollectionIndexEntity} from "../../../collection/definitions/entity/collection";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedService,
        PublicCollectionsSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class CollectionsRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<CollectionIndexEntity>,
        private source: PublicCollectionsSource
    ) {
        catalog.source = 'collections';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<CollectionIndexEntity>());
        service.update();
    }
}