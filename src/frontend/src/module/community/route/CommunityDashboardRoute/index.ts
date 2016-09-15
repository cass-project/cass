import {Component} from "@angular/core";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CommunityRouteService} from "../CommunityRoute/service";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {AuthService} from "../../../auth/service/AuthService";

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
export class CommunityDashboardRoute
{
    main_collection: CollectionEntity;
    postType: PostTypeEntity;
    
    constructor(
        private authService: AuthService,
        private service: CommunityRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: CollectionSource,
        private types: PostTypeService
        
    ) {
        this.postType = types.getTypeByStringCode('default');

        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                    for(let collection of response.entity.collections){
                        if(collection.is_main){
                            this.main_collection = collection;
                        }
                    }
                    
                    feedSource.collectionId = this.main_collection.id;
                    feed.provide(feedSource, new Stream<PostEntity>());
                    feed.update();
                },
                (error) => {
                }
            );
        }
    }


    canPost(): boolean{
       return this.authService.isSignedIn();
    }
    
    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}