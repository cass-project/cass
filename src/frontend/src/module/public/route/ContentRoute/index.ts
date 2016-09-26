import {Component, ViewChild, ElementRef} from "@angular/core";

import {FeedService} from "../../../feed/service/FeedService/index";
import {PublicContentSource} from "../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../feed/service/FeedService/stream";
import {PublicService} from "../../service";
import {PostIndexedEntity} from "../../../post/definitions/entity/Post";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {UIService} from "../../../ui/service/ui";
import {NavigationObservable} from "../../../navigator/service/NavigationObservable";

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
export class ContentRoute
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<PostIndexedEntity>,
        private source: PublicContentSource,
        private ui: UIService,
        private navigator: NavigationObservable
    ) {
        catalog.source = 'content';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<PostIndexedEntity>());
        service.update();
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}