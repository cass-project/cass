import {Injectable} from "angular2/core";
import {CollectionLeaf} from "../Collection";
import {FrontlineService} from "../../frontline/service";

@Injectable()
export class CollectionService
{
    collections: CollectionLeaf[];
    
    constructor(frontline: FrontlineService) {
        if(frontline.session.collections) {
            this.collections = frontline.session.collections;
        }
    }
}