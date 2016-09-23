import {Injectable, ElementRef} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";

@Injectable()
export class NavigationObservable
{
    public scroll: Observable<ScrollEvent>;

    public top: Observable<boolean>;
    public prev: Observable<number>;
    public next: Observable<number>;
    public bottom: Observable<boolean>;

    private observerScroll: Observer<ScrollEvent>;
    private observerTop: Observer<boolean>;
    private observerPrev: Observer<number>;
    private observerNext: Observer<number>;
    private observerBottom: Observer<boolean>;

    constructor() {
        this.scroll = Observable.create(observer => {
            this.observerScroll = observer;
        });

        this.top = Observable.create(observer => {
            this.observerTop = observer;
        });

        this.prev = Observable.create(observer => {
            this.observerPrev = observer;
        });

        this.next = Observable.create(observer => {
            this.observerNext = observer;
        });

        this.bottom = Observable.create(observer => {
            this.observerBottom = observer;
        });
    }

    public emitScroll(elem: ElementRef) {
        this.observerScroll.next({
            elem: elem
        });
    }

    public emitTop() {
        this.observerTop.next(true);
    }

    public emitPrev(num: number) {
        this.observerPrev.next(num);
    }

    public emitNext(num: number) {
        this.observerNext.next(num);
    }

    public emitBottom() {
        this.observerBottom.next(true);
    }
}

export interface ScrollEvent
{
    elem: ElementRef;
}