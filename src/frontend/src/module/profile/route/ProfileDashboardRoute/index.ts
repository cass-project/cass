import {Component} from "angular2/core";

import {ProfileCardsList} from "../../component/Elements/ProfileCardsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
import {FeedPostStream} from "../../../feed/component/stream/FeedPostStream/index";
import {ProfileSource} from "../../../feed/service/FeedService/source/ProfileSource";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Stream} from "../../../feed/service/FeedService/stream";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {PostForm} from "../../../post/component/Forms/PostForm/index";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedService,
        ProfileSource,
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
        private service: ProfileRouteService,
        private feed: FeedService<PostEntity>,
        private feedSource: ProfileSource,
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

                    feedSource.profileId = response.entity.profile.id;
                    feed.provide(feedSource, new Stream<PostEntity>());
                    feed.update();
                },
                (error) => {
                }
            );
        }
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }
}