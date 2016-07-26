import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {NothingFound} from "../../component/Elements/NothingFound/index";
import {FeedCommunityStream} from "../../../feed/component/stream/FeedCommunityStream/index";
import {CommunityIndexedEntity} from "../../../community/definitions/entity/Community";
import {PublicCommunitiesSource} from "../../../feed/service/FeedService/source/public/PublicCommunitiesSource";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        PublicCommunitiesSource,
    ],
    directives: [
        FeedCommunityStream,
        NothingFound,
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