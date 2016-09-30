import {Component, OnInit, OnDestroy} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Subscription";

import {ProfileRouteService} from "../ProfileRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ProfileEntity} from "../../definitions/entity/Profile";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        CollectionSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class ProfileCollectionRoute implements OnInit, OnDestroy
{
    private sub: Subscription;
    private profile: ProfileEntity;
    private collection: CollectionEntity;
    private postType: PostTypeEntity;

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private service: ProfileRouteService,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource
    ) {}
    
    ngOnInit(){
        this.postType = this.types.getTypeByStringCode('default');
        this.sub = this.route.params.subscribe(params => {
            let sid = params['sid'];
            this.profile = this.service.getProfile();

            let collections = this.service.getCollections().filter((entity: CollectionEntity) => {
                return entity.sid === sid;
            });

            if(! collections.length) {
                this.router.navigate(['/profile/collections/not-found']);
            }

            this.collection = collections[0];

            this.feedSource.collectionId = this.collection.id;
            this.feed.provide(this.feedSource, new Stream<PostEntity>());
            this.feed.update();
        })
    }

    ngOnDestroy(){
        this.sub.unsubscribe();
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
    
    isLoaded(): boolean {
        return typeof this.collection === "object";
    }

    isOwn(): boolean {
        return this.service.isOwnProfile();
    }

    doNothing() {}
}