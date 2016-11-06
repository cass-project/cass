import {Component, ViewChild, OnInit, OnDestroy, ElementRef} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PublicCommunitiesSource} from "../../../../feed/service/FeedService/source/public/PublicCommunitiesSource";
import {CommunityIndexedEntity} from "../../../../community/definitions/entity/Community";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {UINavigationObservable} from "../../../../ui/service/navigation";
import {CommunityRouteHelper} from "./helper";
import {ThemeRouteHelper} from "../../theme-route-helper";

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
        CommunityRouteHelper,
        ThemeRouteHelper,
    ]
})
export class CommunitiesRoute implements OnInit, OnDestroy
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<CommunityIndexedEntity>,
        private source: PublicCommunitiesSource,
        private helper: CommunityRouteHelper,
        private navigator: UINavigationObservable,
    ) {
        catalog.source = 'communities';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<CommunityIndexedEntity>());
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