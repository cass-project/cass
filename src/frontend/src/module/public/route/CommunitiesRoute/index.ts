import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {PublicContentSource} from "../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {PublicService} from "../../service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        PublicContentSource,
    ],
    directives: [
        FeedPostStream,
    ]
})
export class CommunitiesRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<PostEntity>,
        private source: PublicContentSource
    ) {
        catalog.source = 'communities';
        
        service.provide(source, new Stream<PostEntity>());
        service.criteria = catalog.criteria;
        service.update();
    }
}