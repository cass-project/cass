import {Observable} from "rxjs/Observable";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";
import {Observer} from "rxjs/Observer";
import {Injectable} from "@angular/core";

@Injectable()
export class CommunityCreateModalNotifier
{
    private observer: Observer<CommunityExtendedEntity>;
    public observable: Observable<CommunityExtendedEntity>;

    publish(entity: CommunityExtendedEntity) {
        if(this.observer) {
            this.observer.next(entity);
        }
    }
    
    constructor() {
        this.observable = Observable.create(observer => {
            this.observer = observer;
        }).publish().refCount();
    }
}