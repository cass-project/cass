import {Component} from "angular2/core";

import {CommunityCardsList} from "../../component/Elements/CommunityCardsList/index";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {CommunitySource} from "../../../feed/service/FeedService/source/CommunitySource";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {ProfileRouteService} from "../../../profile/route/ProfileRoute/service";
import {CommunityRouteService} from "../CommunityRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        CommunitySource,
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
        private feedSource: CommunitySource
    ) {
        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                    feedSource.communityId = response.entity.community.id;
                    feed.provide(feedSource, new Stream<PostEntity>());
                    feed.update();
                },
                (error) => {
                }
            );
        }
    }
}