import {Component, OnInit} from "@angular/core";
import {Router, Routes, RouterModule, ActivatedRoute} from '@angular/router';
import {Observable} from "rxjs/Observable";
import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostForm} from "../../../post/component/Forms/PostForm/index";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {FeedService} from "../../../feed/service/FeedService/index";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
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
export class ProfileCollectionRoute implements OnInit
{
    collection: CollectionEntity;
    postType: PostTypeEntity;

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private service: ProfileRouteService,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource,
        private sidCollection: string
    ) {}
    
    ngOnInit(){
        this.postType = this.types.getTypeByStringCode('default');

        const sub: Observable<string> = this.route.params.map(params => {
            this.sidCollection = params['sid'];
        });

        this.service.getObservable().subscribe(
            (response) => {
                let sid = this.sidCollection;
                let collections = response.entity.collections.filter((entity: CollectionEntity) => {
                    return entity.sid === sid;
                });

                if(! collections.length) {
                    this.router.navigate(['NotFound']);
                }

                this.collection = collections[0];

                this.feedSource.collectionId = this.collection.id;
                this.feed.provide(this.feedSource, new Stream<PostEntity>());
                this.feed.update();
            },
            (error) => {}
        );
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
    
    isLoaded(): boolean {
        return typeof this.collection === "object";
    }
}