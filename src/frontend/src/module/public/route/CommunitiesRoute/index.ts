import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {CommunityIndexedEntity} from "../../../community/definitions/entity/Community";
import {PublicCommunitiesSource} from "../../../feed/service/FeedService/source/public/PublicCommunitiesSource";
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
        PublicCommunitiesSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class CommunitiesRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<CommunityIndexedEntity>,
        private source: PublicCommunitiesSource
    ) {
        catalog.source = 'communities';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<CommunityIndexedEntity>());
        service.update();
    }
}