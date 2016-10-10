import {Injectable} from "@angular/core";

import {CollectionEntity} from "../definitions/entity/collection";

@Injectable()
export class CollectionService
{
    getRouterParams(collection: CollectionEntity) {
        if(collection.owner.type === 'profile') {
            return ['/profile', collection.owner.id, 'collections', collection.sid];
        }else if(collection.owner.type === 'community') {
            return ['/community', collection.owner.id, 'collections', collection.sid];
        }else{
            throw new Error(`Unknown owner type for collection "${collection.sid}"`);
        }
    }
}