import {Observable, Observer} from "rxjs/Rx";
import {ElementRef} from "@angular/core";

export class FeedScrollService
{
    private observer: Observer<FeedScrollEvent>;
    private observable: Observable<FeedScrollEvent>;

    constructor() {
        this.observable = Observable.create(observer => {
            this.observer = observer;
        })
    }

    emit(event: FeedScrollEvent) {
        this.observer.next(event);
    }
    
    getObservable(): Observable<FeedScrollEvent> {
        return this.observable;
    }
}

export interface FeedScrollEvent
{
    html: ElementRef;
}