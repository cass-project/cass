import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {Session} from "../../../session/Session";
import {ProfileRouteService} from "../ProfileRoute/service";

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
    private main_collection: CollectionEntity;
    private postType: PostTypeEntity;

    constructor(
        private session: Session,
        private service: ProfileRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource,
        private types: PostTypeService
    ) {
        this.postType = types.getTypeByStringCode('default');

        for(let collection of service.getCollections()){
            if(collection.is_main){
                this.main_collection = collection;
            }
        }

        feedSource.collectionId = this.main_collection.id;
        feed.provide(feedSource, new Stream<PostEntity>());
        feed.update();
    }

    canPost(): boolean {
        if(this.session.isSignedIn()) {
            let testIsOwnProfile = () => { return this.service.isOwnProfile() };
            let testIsCurrentProfile = () => { return this.service.getProfile().id === this.session.getCurrentProfile().getId(); };

            return testIsOwnProfile()
                && testIsCurrentProfile();
        } else {
            return false
        }
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}