import {Injectable} from "@angular/core";
import {PostEntity} from "../../../post/definitions/entity/Post";

@Injectable()
export class FeedEntitiesService
{
    private entities: PostEntity[] = [];
    
    push(entities: PostEntity[]) {
        entities.forEach(input => {
            this.entities.push(input);
        })
    }

    unshift(entity: PostEntity) {
        this.entities.unshift(entity);
    }
}