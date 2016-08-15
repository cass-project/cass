import {Injectable} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";

import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";

@Injectable()
export class CommunityCreateModalNotifier
{
    private observer: Observer<CommunityExtendedEntity>;
    public observable: Observable<CommunityExtendedEntity>;

    publish(entity: CommunityExtendedEntity) {
        this.observer.next(entity);
    }
    
    constructor() {
        this.observable = Observable.create(observer => {
            this.observer = observer;
        }).publish().refCount();
    }
}