import {Injectable} from "@angular/core";
import {Observer, Observable} from "rxjs/Rx";

import {CommunityEntity} from "../../../definitions/entity/Community";

@Injectable()
export class CommunityJoinModalNotifier
{
    private observer: Observer<CommunityEntity>;
    public observable: Observable<CommunityEntity>;

    publish(entity: CommunityEntity) {
        this.observer.next(entity);
    }
    
    constructor() {
        this.observable = Observable.create(observer => {
            this.observer = observer;
        }).publish().refCount();
    }
}