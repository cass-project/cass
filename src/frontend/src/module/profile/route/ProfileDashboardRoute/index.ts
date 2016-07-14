import {Component} from "angular2/core";

import {ProfileCardsList} from "../../component/Elements/ProfileCardsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
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
        ProfileCardsList,
        FeedPostStream,
    ]
})
export class ProfileDashboardRoute
{
    constructor(
        private service: ProfileRouteService,
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