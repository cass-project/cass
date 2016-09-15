import {OnInit, OnDestroy, Component} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Subscription";
import {CommunityRouteService} from "../CommunityRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";

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
export class CommunityCollectionRoute implements OnInit, OnDestroy
{
    collection: CollectionEntity;
    postType: PostTypeEntity;

    private sub: Subscription;

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private service: CommunityRouteService,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource
    ) {
        this.postType = types.getTypeByStringCode('default');
    }

    ngOnInit(){
        this.sub = this.route.params.subscribe(params => {
            this.service.getObservable().subscribe(
                (response) => {
                    let sid = this.route.params.subscribe['sid'];
                    let collections = response.entity.collections.filter((entity:CollectionEntity) => {
                        return entity.sid === sid;
                    });

                    if (!collections.length) {
                        this.router.navigate(['NotFound']);
                    }

                    this.collection = collections[0];

                    this.feedSource.collectionId = this.collection.id;
                    this.feed.provide(this.feedSource, new Stream<PostEntity>());
                    this.feed.update();
                },
                (error) => {}
            );
        });
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }

    isLoaded(): boolean {
        return typeof this.collection === "object";
    }
    

    ngOnDestroy(){
        this.sub.unsubscribe();
    }
}