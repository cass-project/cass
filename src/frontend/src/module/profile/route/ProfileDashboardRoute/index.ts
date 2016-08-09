import {Component} from "@angular/core";

import {ProfileCardsList} from "../../component/Elements/ProfileCardsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostForm} from "../../../post/component/Forms/PostForm/index";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {CollectionSource} from "../../../feed/service/FeedService/source/CollectionSource";
import {ProfileEntity} from "../../definitions/entity/Profile";
import {CurrentProfileService} from "../../service/CurrentProfileService";
import {AuthService} from "../../../auth/service/AuthService";

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
        ProfileCardsList,
        FeedPostStream,
        PostForm
    ]
})
export class ProfileDashboardRoute
{

    main_collection: CollectionEntity;
    postType: PostTypeEntity;

    constructor(
        private authService: AuthService,
        private currentProfileService: CurrentProfileService,
        private service: ProfileRouteService,
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
        if(this.authService.isSignedIn()) {
            return this.service.getProfile().is_own && this.service.getProfile().profile.id === this.currentProfileService.get().getId();
        } else {
            return false
        }
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}