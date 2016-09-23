import {Injectable, ElementRef} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";

@Injectable()
export class NavigationObservable
{
    static SCROLL_THRESHOLD = 5;

    public scroll: Observable<ScrollEvent>;

    public top: Observable<boolean>;
    public prev: Observable<number>;
    public next: Observable<number>;
    public bottom: Observable<boolean>;

    public observerScroll: Observer<ScrollEvent>;
    public observerTop: Observer<boolean>;
    public observerPrev: Observer<number>;
    public observerNext: Observer<number>;
    public observerBottom: Observer<boolean>;

    constructor() {
        this.scroll = Observable.create(observer => {
            this.observerScroll = observer;
        }).publish().refCount();

        this.top = Observable.create(observer => {
            this.observerTop = observer;
        }).publish().refCount();

        this.prev = Observable.create(observer => {
            this.observerPrev = observer;
        }).publish().refCount();

        this.next = Observable.create(observer => {
            this.observerNext = observer;
        }).publish().refCount();

        this.bottom = Observable.create(observer => {
            this.observerBottom = observer;
        }).publish().refCount();

        [this.scroll, this.top, this.prev, this.next].forEach((observable: Observable<any>) => {
            observable.subscribe(() => {}, () => {});
        });
    }

    public emitScroll(elem: ElementRef) {
        let scrollTop = elem.nativeElement.scrollTop;
        let scrollBottom = elem.nativeElement.scrollTop + elem.nativeElement.scrollHeight;
        let scrollTotal = elem.nativeElement.scrollHeight;
        let clientHeight = elem.nativeElement.clientHeight;

        this.observerScroll.next({
            elem: elem,
            scrollTotal: scrollTotal,
            scrollTop: scrollTop,
            scrollBottom: scrollBottom,
            clientHeight: elem.nativeElement.clientHeight,
            maybe: {
                top: scrollTop <= NavigationObservable.SCROLL_THRESHOLD,
                bottom: (scrollTop + clientHeight - scrollTotal) <= NavigationObservable.SCROLL_THRESHOLD,
            },
            exact: {
                top: scrollTop === 0,
                bottom: (scrollTop + clientHeight - scrollTotal) === 0,
            },
            percent: Math.max(0, Math.min(100,
                scrollBottom * (100/scrollTotal)
            ))
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
    scrollTop: number;
    scrollBottom: number;
    scrollTotal: number;
    clientHeight: number;
    percent: number;
    maybe: {
        top: boolean;
        bottom: boolean;
    },
    exact: {
        top: boolean;
        bottom: boolean;
    }
}