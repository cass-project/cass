import {Injectable, ElementRef} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";
import {UIStrategy} from "../strategy/NavigationStrategy/ui.strategy";

@Injectable()
export class UINavigationObservable
{
    private strategy: UIStrategy;

    static SCROLL_THRESHOLD = 5;

    public scroll: Observable<ScrollEvent>;

    public top: Observable<boolean>;
    public prev: Observable<number>;
    public next: Observable<number>;
    public bottom: Observable<boolean>;
    public up: Observable<boolean>;
    public down: Observable<boolean>;
    public left: Observable<boolean>;
    public right: Observable<boolean>;
    public enter: Observable<boolean>;

    public observerScroll: Observer<ScrollEvent>;
    public observerTop: Observer<boolean>;
    public observerPrev: Observer<boolean>;
    public observerNext: Observer<boolean>;
    public observerBottom: Observer<boolean>;
    public observerUp: Observer<boolean>;
    public observerDown: Observer<boolean>;
    public observerLeft: Observer<boolean>;
    public observerRight: Observer<boolean>;
    public observerEnter: Observer<boolean>;

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

        this.up = Observable.create(observer => {
            this.observerUp = observer;
        }).publish().refCount();

        this.down = Observable.create(observer => {
            this.observerDown = observer;
        }).publish().refCount();

        this.left = Observable.create(observer => {
            this.observerLeft = observer;
        }).publish().refCount();

        this.right = Observable.create(observer => {
            this.observerRight = observer;
        }).publish().refCount();

        this.bottom = Observable.create(observer => {
            this.observerBottom = observer;
        }).publish().refCount();

        this.enter = Observable.create(observer => {
            this.observerEnter = observer;
        }).publish().refCount();

        [this.scroll, this.top, this.prev, this.next, this.up, this.down, this.left, this.right, this.bottom, this.enter].forEach((observable: Observable<any>) => {
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
                top: scrollTop <= UINavigationObservable.SCROLL_THRESHOLD,
                bottom: (scrollTop + clientHeight - scrollTotal) <= UINavigationObservable.SCROLL_THRESHOLD,
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

    public setStrategy(strategy){
        this.strategy = strategy;
    }

    public emitTop() {
        this.observerTop.next(true);
    }

    public emitPrev() {
        this.observerPrev.next(true);
    }

    public emitNext() {
        this.observerNext.next(true);
    }

    public emitUp(){
        this.observerUp.next(true);
    }

    public emitDown(){
        this.observerDown.next(true);
    }

    public emitLeft(){
        this.observerLeft.next(true);
    }

    public emitRight(){
        this.observerRight.next(true);
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