import {Injectable, ElementRef} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";
import {UIStrategy} from "../strategy/NavigationStrategy/ui.strategy";
import {ViewOptionService} from "../../public/component/Options/ViewOption/service";
import {ViewOptionValue} from "../../feed/service/FeedService/options/ViewOption";
import {FeedStrategy} from "../strategy/NavigationStrategy/feed.strategy";
import {GridStrategy} from "../strategy/NavigationStrategy/grid.strategy";
import {ListStrategy} from "../strategy/NavigationStrategy/list.strategy";
import {Subscription} from "rxjs/Rx";
import {NoneStrategy} from "../strategy/NavigationStrategy/none.strategy";

@Injectable()
export class UINavigationObservable
{
    private strategy: UIStrategy;
    private subscriptions: Subscription[];

    static SCROLL_THRESHOLD = 5;

    public scroll: Observable<ScrollEvent>;

    public top: Observable<boolean>;
    public bottom: Observable<boolean>;
    public up: Observable<boolean>;
    public down: Observable<boolean>;
    public left: Observable<boolean>;
    public right: Observable<boolean>;
    public enter: Observable<boolean>;

    public observerScroll: Observer<ScrollEvent>;
    public observerTop: Observer<boolean>;
    public observerBottom: Observer<boolean>;
    public observerUp: Observer<boolean>;
    public observerDown: Observer<boolean>;
    public observerLeft: Observer<boolean>;
    public observerRight: Observer<boolean>;
    public observerEnter: Observer<boolean>;

    constructor(private viewOptionService: ViewOptionService) {
        this.scroll = Observable.create(observer => {
            this.observerScroll = observer;
        }).publish().refCount();

        this.top = Observable.create(observer => {
            this.observerTop = observer;
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
        
    }

    initNavigation(content){
        if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'feed'){
            this.setStrategy(new FeedStrategy(content));
        } else if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'grid'){
            this.setStrategy(new GridStrategy(content));
        } else if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'list'){
            this.setStrategy(new ListStrategy(content));
        } else {
            throw new Error('ViewOptionService.LOCAL_STORAGE_KEY unknown view')
        }

        this.subscriptions = [
            this.top.subscribe(() => {
                this.strategy.top();
            }),

            this.bottom.subscribe(() => {
                this.strategy.bottom();
            }),

            this.left.subscribe(() => {
                this.strategy.left();
            }),

            this.right.subscribe(() => {
                this.strategy.right();
            }),

            this.up.subscribe(() => {
                this.strategy.up();
            }),

            this.down.subscribe(() => {
                this.strategy.down();
            }),
            
            this.enter.subscribe(() => {
               this.strategy.enter(); 
            }),

            this.scroll.subscribe(() => {}),

            this.viewOptionService.viewMode.subscribe(() => {
                if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'feed'){
                    this.setStrategy(new FeedStrategy(content));
                } else if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'grid'){
                    this.setStrategy(new GridStrategy(content));
                } else if(window.localStorage[ViewOptionService.LOCAL_STORAGE_KEY] === 'list'){
                    this.setStrategy(new ListStrategy(content));
                } else {
                    throw new Error('ViewOptionService.LOCAL_STORAGE_KEY unknown view')
                }
            })
        ];
    }

    destroyNavigation(){
        this.setStrategy(new NoneStrategy());
        this.subscriptions.forEach((subscription) => {
            subscription.unsubscribe();
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

    public emitEnter() {
        this.observerEnter.next(true);
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