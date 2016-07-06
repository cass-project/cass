import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, Router, RouteParams} from "angular2/router";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";
import {PostForm} from "../../../post/component/Forms/PostForm/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
        PostForm
    ]
})
export class ProfileCollectionRoute
{
    collection: CollectionEntity;

    constructor(
        private router: Router,
        private params: RouteParams,
        private service: ProfileRouteService
    ) {
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
    
    isLoaded(): boolean {
        return typeof this.collection === "object";
    }
}