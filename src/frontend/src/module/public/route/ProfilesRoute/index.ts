import {Component} from "angular2/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {FeedProfileStream} from "../../../feed/component/stream/FeedProfileStream/index";
import {PublicProfilesSource} from "../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {NothingFound} from "../../component/Elements/NothingFound/index";
import {ProfileIndexedEntity} from "../../../profile/definitions/entity/Profile";

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
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
        service.update();
    }
}