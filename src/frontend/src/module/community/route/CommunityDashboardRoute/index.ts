import {Component} from "angular2/core";

import {CommunityCardsList} from "../../component/Elements/CommunityCardsList/index";
import {CommunityRouteService} from "../CommunityRoute/service";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {ProfileSource} from "../../../feed/service/FeedService/source/ProfileSource";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        ProfileSource,
    ],
    directives: [
        CommunityCardsList,
        FeedPostStream,
    ]
})
export class CommunityDashboardRoute
{
    constructor(
        private service: CommunityRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: ProfileSource
    ) {
        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                    feedSource.profileId = response.entity.profile.id;
                    feed.provide(feedSource, new Stream<PostEntity>());
                    feed.update();
                },
                (error) => {
                }
            );
        }
    }
}