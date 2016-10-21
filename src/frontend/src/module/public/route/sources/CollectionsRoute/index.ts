import {Component, ViewChild, OnInit, OnDestroy, ElementRef} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PublicCollectionsSource} from "../../../../feed/service/FeedService/source/public/PublicCollectionsSource";
import {CollectionIndexEntity} from "../../../../collection/definitions/entity/collection";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {PublicThemeHelper} from "../../theme-helper";
import {UINavigationObservable} from "../../../../ui/service/navigation";
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
        PublicCollectionsSource,
        FeedCriteriaService,
        FeedOptionsService,
        PublicThemeHelper,
    ]
})
export class CollectionsRoute implements OnInit, OnDestroy
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<CollectionIndexEntity>,
        private source: PublicCollectionsSource,
        private themeHelper: PublicThemeHelper,
        private navigator: UINavigationObservable,
        private ui: UIService,
        private swipe: SwipeService,
        private path: UIPathService
    ) {
        path.setPath([{
            name: 'Подборки',
            route: ['/p/collections']
        }]);

        catalog.source = 'collections';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<CollectionIndexEntity>());
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