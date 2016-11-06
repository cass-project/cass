import {Component, OnInit, OnDestroy, ViewChild, ElementRef} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PublicProfilesSource} from "../../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {PublicThemeHelper} from "../../theme-helper";
import {ThemeRouteHelper} from "../../theme-route-helper";
import {PublicProfilesRouteHelper} from "./helper";
import {UINavigationObservable} from "../../../../ui/service/navigation";

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
        ThemeRouteHelper,
        PublicProfilesRouteHelper,
    ]
})

export class ProfilesRoute implements OnInit, OnDestroy
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource,
        private helper: PublicProfilesRouteHelper,
        private navigator: UINavigationObservable,
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
    }

    ngOnInit() {
        this.navigator.initNavigation(this.content);
    }

    ngOnDestroy(){
        this.navigator.destroyNavigation();
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}