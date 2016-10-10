import {Component, ElementRef, ViewChild, OnInit} from "@angular/core";

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
export class ProfilesRoute implements OnInit
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource,
        private ui: UIService,
        private navigator: UINavigationObservable,
        private swipe: SwipeService,
        private themeHelper: PublicThemeHelper
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
        service.update();
    }

    ngOnInit() {
        this.navigator.top.subscribe(() => {
            this.content.nativeElement.scrollTop = 0;
        });

        this.navigator.bottom.subscribe(() => {
            this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
        });
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}