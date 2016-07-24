import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {PublicService} from "../../service";
import {FeedProfileStream} from "../../../feed/component/stream/FeedProfileStream/index";
import {PublicProfilesSource} from "../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {NothingFound} from "../../component/Elements/NothingFound/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        PublicProfilesSource,
    ],
    directives: [
        FeedProfileStream,
        NothingFound,
    ]
})
export class ProfilesRoute
{
    constructor(
        private catalog: PublicService,
        private service: FeedService<PostEntity>,
        private source: PublicProfilesSource
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<PostEntity>());
        service.update();
    }
}