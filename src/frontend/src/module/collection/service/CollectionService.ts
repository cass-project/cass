import {Injectable} from "@angular/core";

import {CollectionEntity} from "../definitions/entity/collection";
import {Router} from "@angular/router";

@Injectable()
export class CollectionService
{
    constructor(private router: Router) {}

    getRouterParams(collection: CollectionEntity) {
        if(collection.owner.type === 'profile') {
            return ['/profile', collection.owner.id, 'collections', collection.sid];
        }else if(collection.owner.type === 'community') {
            return ['/community', collection.owner.id, 'collections', collection.sid];
        }else{
            throw new Error(`Unknown owner type for collection "${collection.sid}"`);
        }
    }

    navigateCollection(collection: CollectionEntity) {
        this.router.navigate(this.getRouterParams(collection));
    }
}