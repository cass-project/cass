import {Observable} from "rxjs/Observable";
import {Observer} from "rxjs/Observer";
import {Injectable} from "@angular/core";
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