import {Component, ViewChild, OnInit, OnDestroy, ElementRef} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {CommunityIndexedEntity} from "../../../../community/definitions/entity/Community";
import {PublicCommunitiesSource} from "../../../../feed/service/FeedService/source/public/PublicCommunitiesSource";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {UINavigationObservable} from "../../../../ui/service/navigation";
import {PublicThemeHelper} from "../../theme-helper";
import {UIService} from "../../../../ui/service/ui";
import {SwipeService} from "../../../../swipe/service/SwipeService";
import {UIPathService} from "../../../../ui/path/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedService,
        PublicCommunitiesSource,
        FeedCriteriaService,
        FeedOptionsService,
        PublicThemeHelper
    ]
})
export class CommunitiesRoute implements OnInit, OnDestroy
{
    @ViewChild('content') content: ElementRef;
    
    constructor(
        private catalog: PublicService,
        private service: FeedService<CommunityIndexedEntity>,
        private source: PublicCommunitiesSource,
        private themeHelper: PublicThemeHelper,
        private navigator: UINavigationObservable,
        private ui: UIService,
        private swipe: SwipeService,
        private path: UIPathService,
    ) {
        path.setPath([{
            name: 'Сообщества',
            route: ['/p/communities']
        }]);

        catalog.source = 'communities';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<CommunityIndexedEntity>());
        service.update();
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