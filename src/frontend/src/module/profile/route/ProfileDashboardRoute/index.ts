import {Component} from "@angular/core";

import {ProfileRouteService} from "../ProfileRoute/service";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {AuthService} from "../../../auth/service/AuthService";
import {Session} from "../../../session/Session";
import {ProfileEntity} from "../../definitions/entity/Profile";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        CollectionSource
    ]
})
export class ProfileDashboardRoute
{
    private profile: ProfileEntity;
    private main_collection: CollectionEntity;
    private postType: PostTypeEntity;

    constructor(
        private authService: AuthService,
        private session: Session,
        private service: ProfileRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource,
        private types: PostTypeService
    ) {
        this.postType = types.getTypeByStringCode('default');

        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                    this.profile = response.entity.profile;

                    for(let collection of response.entity.collections){
                        if(collection.is_main){
                            this.main_collection = collection;
                        }
                    }

                    feedSource.collectionId = this.main_collection.id;
                    feed.provide(feedSource, new Stream<PostEntity>());
                    feed.update();
                },
                (error) => {}
            );
        }
    }

    canPost(): boolean {
        if(this.authService.isSignedIn()) {
            return this.service.getProfile().is_own && this.service.getProfile().profile.id === this.session.getCurrentProfile().getId();
        } else {
            return false
        }
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}