import {Component} from "@angular/core";
import {RouteParams, RouteConfig} from "@angular/router";
import {ROUTER_DIRECTIVES, Router} from '@angular/router';

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {CommunityRouteService} from "../CommunityRoute/service";
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
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
        PostForm,
        FeedPostStream,
    ]
})
export class CommunityCollectionRoute
{
    collection: CollectionEntity;
    postType: PostTypeEntity;

    constructor(
        private router: Router,
        private params: RouteParams,
        private service: CommunityRouteService,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource
    ) {
        this.postType = types.getTypeByStringCode('default');

        service.getObservable().subscribe(
            (response) => {
                let sid = params.get('sid');
                let collections = response.entity.collections.filter((entity: CollectionEntity) => {
                    return entity.sid === sid;
                });

                if(! collections.length) {
                    router.navigate(['NotFound']);
                }

                this.collection = collections[0];

                feedSource.collectionId = this.collection.id;
                feed.provide(feedSource, new Stream<PostEntity>());
                feed.update();
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