import {Component, ElementRef, ViewChild, OnInit, OnDestroy} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PublicProfilesSource} from "../../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {UIService} from "../../../../ui/service/ui";
import {UINavigationObservable} from "../../../../ui/service/navigation";
import {SwipeService} from "../../../../swipe/service/SwipeService";
import {PublicThemeHelper} from "../../theme-helper";
import {Observable, Observer} from "rxjs/Rx";
import {ViewOptionService} from "../../../component/Options/ViewOption/service";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {FeedStrategy} from "../../../../ui/strategy/NavigationStrategy/feed.strategy";
import {NoneStrategy} from "../../../../ui/strategy/NavigationStrategy/none.strategy";
import {GridStrategy} from "../../../../ui/strategy/NavigationStrategy/grid.strategy";
import {ListStrategy} from "../../../../ui/strategy/NavigationStrategy/list.strategy";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedService,
        PublicProfilesSource,
        FeedCriteriaService,
        FeedOptionsService,
        PublicThemeHelper,
    ]
})

export class ProfilesRoute implements OnInit, OnDestroy
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource,
        private ui: UIService,
        private navigator: UINavigationObservable,
        private swipe: SwipeService,
        private themeHelper: PublicThemeHelper,
        private viewOptionService: ViewOptionService
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
        service.update();
    }

    ngOnInit() {
        if(this.viewOptionService.isOn(ViewOptionValue.Feed)){
            console.log(ViewOptionValue.Feed);
            this.navigator.setStrategy(new FeedStrategy(this.content));
        } else if(this.viewOptionService.isOn(ViewOptionValue.Grid)){
            console.log(ViewOptionValue.Grid);
            this.navigator.setStrategy(new GridStrategy(this.content));
        } else if(this.viewOptionService.isOn(ViewOptionValue.List)){
            console.log(ViewOptionValue.List);
            this.navigator.setStrategy(new ListStrategy(this.content));
        } else {
            throw new Error('this.viewOptionService.isOn get wrong parameter')
        }

        this.viewOptionService.viewMode.subscribe(() => {
           if(this.viewOptionService.isOn(ViewOptionValue.Feed)){
               console.log(ViewOptionValue.Feed);
               this.navigator.setStrategy(new FeedStrategy(this.content));
           } else if(this.viewOptionService.isOn(ViewOptionValue.Grid)){
               console.log(ViewOptionValue.Grid);
               this.navigator.setStrategy(new GridStrategy(this.content));
           } else if(this.viewOptionService.isOn(ViewOptionValue.List)){
               console.log(ViewOptionValue.List);
               this.navigator.setStrategy(new ListStrategy(this.content));
           } else {
               throw new Error('this.viewOptionService.isOn get wrong parameter')
           }

            //ToDo: Выделить весь ngOnInit, в отдельную фабрику
        });
    }

    ngOnDestroy(){
        this.navigator.setStrategy(new NoneStrategy(this.content));
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}