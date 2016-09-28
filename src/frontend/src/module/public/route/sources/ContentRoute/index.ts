import {Component, ViewChild, ElementRef, OnInit} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {PublicContentSource} from "../../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PostIndexedEntity} from "../../../../post/definitions/entity/Post";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {UIService} from "../../../../ui/service/ui";
import {UINavigationObservable} from "../../../../ui/service/navigation";
import {SwipeService} from "../../../../swipe/service/SwipeService";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {Theme} from "../../../../theme/definitions/entity/Theme";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedService,
        PublicContentSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class ContentRoute implements OnInit
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<PostIndexedEntity>,
        private source: PublicContentSource,
        private ui: UIService,
        private navigator: UINavigationObservable,
        private swipe: SwipeService,
        private theme: ThemeService,
        private criteria: FeedCriteriaService
    ) {
        catalog.source = 'content';
        catalog.injectFeedService(service);

        service.provide(source, new Stream<PostIndexedEntity>());
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

    getThemeRoot() {
        let criteria = this.criteria.criteria.theme;

        if(criteria.enabled) {
            return this.theme.findById(criteria.params.id);
        }else{
            return this.theme.getRoot();
        }
    }

    goTheme(theme: Theme) {
        let criteria = this.criteria.criteria.theme;

        criteria.enabled = true;
        criteria.params.id = theme.id;

        if(theme.children.length === 0) {
            this.swipe.switchToContent();
        }

        this.service.update();
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}