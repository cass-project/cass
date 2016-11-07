import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {Session} from "../../../session/Session";
import {ProfileRouteService} from "../ProfileRoute/service";
import {ProfileSource} from "../../../feed/service/FeedService/source/ProfileSource";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        ProfileSource,
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
        private feedSource: ProfileSource,
        private types: PostTypeService
    ) {
        this.postType = types.getTypeByStringCode('default');

        for(let collection of service.getCollections()){
            if(collection.is_main){
                this.main_collection = collection;
            }
        }

        feedSource.profileId = service.getProfile().id;
        feed.provide(feedSource, new Stream<PostEntity>());
        feed.update();
    }

    getEntity(){
        if(this.service.getEntity().is_own){
            return this.session.getCurrentProfile().entity;
        } else {
            return this.service.getEntity();
        }
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