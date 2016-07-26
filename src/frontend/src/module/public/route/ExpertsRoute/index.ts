import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {FeedProfileStream} from "../../../feed/component/stream/FeedProfileStream/index";
import {PublicExpertsSource} from "../../../feed/service/FeedService/source/public/PublicExpertsSource";
import {NothingFound} from "../../component/Elements/NothingFound/index";
import {ProfileIndexedEntity} from "../../../profile/definitions/entity/Profile";

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
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicExpertsSource
    ) {
        catalog.source = 'experts';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<ProfileIndexedEntity>());
        service.update();
    }
}