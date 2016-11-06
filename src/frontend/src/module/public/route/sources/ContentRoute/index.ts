import {Component, ElementRef, ViewChild} from "@angular/core";

import {ThemeRouteHelper} from "../../theme-route-helper";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {PostIndexedEntity} from "../../../../post/definitions/entity/Post";
import {FeedService} from "../../../../feed/service/FeedService/index";
import {PublicService} from "../../../service";
import {PublicContentSource} from "../../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {ContentRouteHelper} from "./helper";
import {UINavigationObservable} from "../../../../ui/service/navigation";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ],
    providers: [
        PublicService,
        FeedService,
        PublicContentSource,
        FeedCriteriaService,
        FeedOptionsService,
        ContentRouteHelper,
        ThemeRouteHelper,
    ]
})
export class ContentRoute
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<PostIndexedEntity>,
        private source: PublicContentSource,
        private helper: ContentRouteHelper,
        private navigator: UINavigationObservable,
    ) {
        catalog.source = 'content';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<PostIndexedEntity>());
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