import {Component} from "@angular/core";

import {UIService} from "../../../../ui/service/ui";
import {ThemeRouteHelper} from "../../theme-route-helper";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {PostIndexedEntity} from "../../../../post/definitions/entity/Post";
import {FeedService} from "../../../../feed/service/FeedService/index";
import {PublicService} from "../../../service";
import {PublicContentSource} from "../../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ],
    providers: [
        ThemeRouteHelper,
        PublicService,
        FeedService,
        PublicContentSource,
        FeedCriteriaService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class ContentGatewayRoute
{
    constructor(
        private ui: UIService,
        private helper: ThemeRouteHelper,
        private catalog: PublicService,
        private service: FeedService<PostIndexedEntity>,
        private source: PublicContentSource,
    ) {
        catalog.source = 'content';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<PostIndexedEntity>());
    }
}