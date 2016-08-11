import {Component} from "@angular/core";

import {CommunityCardsList} from "../../component/Elements/CommunityCardsList/index";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {PostForm} from "../../../post/component/Forms/PostForm/index";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {CommunityService} from "../../service/CommunityService";
import {Session} from "../../../session/Session";
import {LoadingManager} from "../../../common/classes/LoadingStatus";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        CollectionSource
    ],
    directives: [
        CommunityCardsList,
        FeedPostStream,
        PostForm
    ]
})
export class CommunityDashboardRoute
{
    public mainCollection: CollectionEntity;
    public postType: PostTypeEntity;
    public loading: LoadingManager = new LoadingManager();
    public communityLoading = this.loading.addLoading();
    
    constructor(
        private session: Session,
        private communityService: CommunityService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource,
        private types: PostTypeService
        
    ) {
        this.postType = types.getTypeByStringCode('default');
        communityService.communityObservable.subscribe(data => {
            this.communityLoading.is = false;
            this.mainCollection = data.entity.collections.filter(
                collection => collection.is_main
            )[0];
            feedSource.collectionId = this.mainCollection.id;
            feed.provide(feedSource, new Stream<PostEntity>());
            feed.update();
        });
    }


    canPost(): boolean {
        return this.session.isSignedIn();
    }
    
    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}