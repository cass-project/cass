import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {PublicService} from "../../service";
import {FeedProfileStream} from "../../../feed/component/stream/FeedProfileStream/index";
import {PublicExpertsSource} from "../../../feed/service/FeedService/source/public/PublicExpertsSource";
import {NothingFound} from "../../component/Elements/NothingFound/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        PublicExpertsSource,
    ],
    directives: [
        FeedProfileStream,
        NothingFound,
    ]
})
export class ExpertsRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<PostEntity>,
        private source: PublicExpertsSource
    ) {
        catalog.source = 'experts';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<PostEntity>());
        service.criteria = catalog.criteria;
        service.update();
    }
}