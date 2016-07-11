import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, Router, RouteParams} from "angular2/router";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";
import {PostForm} from "../../../post/component/Forms/PostForm/index";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../post/service/PostTypeService";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {ProfileCollectionFeed} from "../../component/Elements/ProfileCollectionFeed/index";
import {FeedEntitiesService} from "./service";
import {PostEntity} from "../../../post/definitions/entity/Post";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        FeedCriteriaService,
        FeedEntitiesService,
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
        PostForm,
        ProfileCollectionFeed,
    ]
})
export class ProfileCollectionRoute
{
    collection: CollectionEntity;
    postType: PostTypeEntity;

    constructor(
        private router: Router,
        private params: RouteParams,
        private service: ProfileRouteService,
        private types: PostTypeService,
        private entities: FeedEntitiesService
    ) {
        this.postType = types.getTypeByStringCode('default');

        service.getObservable().subscribe(
            (response: GetProfileByIdResponse200) => {
                let sid = params.get('sid');
                let collections = response.entity.collections.filter((entity: CollectionEntity) => {
                    return entity.sid === sid;
                });
                
                if(! collections.length) {
                    router.navigate(['NotFound']);
                }
                
                this.collection = collections[0];
            },
            (error) => {}
        );
    }

    unshiftEntity(entity: PostEntity) {
        this.entities.unshift(entity);
    }
    
    isLoaded(): boolean {
        return typeof this.collection === "object";
    }
}