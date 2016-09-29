import {Component} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {Session} from "../../../session/Session";
import {ProfileSource} from "../../../feed/service/FeedService/source/ProfileSource";
import {CommunityRouteService} from "../CommunityRoute/service";
import {CommunitySource} from "../../../feed/service/FeedService/source/CommunitySource";

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
export class CommunityDashboardRoute
{
    private main_collection: CollectionEntity;
    private postType: PostTypeEntity;

    constructor(
        private session: Session,
        private service: CommunityRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: CommunitySource,
        private types: PostTypeService
    ) {
        this.postType = types.getTypeByStringCode('default');

        for(let collection of service.getCollections()){
            if(collection.is_main){
                this.main_collection = collection;
            }
        }

        feedSource.communityId = service.getCommunity().id;
        feed.provide(feedSource, new Stream<PostEntity>());
        feed.update();
    }

    canPost(): boolean {
        if(this.session.isSignedIn()) {
            let testIsOwnCommunity = () => { return this.service.isOwnCommunity() };
            
            //TODO: Ну тут тебе надо будет сделать всякие права доступа и тому подобное...

            return testIsOwnCommunity()
        } else {
            return false
        }
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}