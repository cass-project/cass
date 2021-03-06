import {Component, ViewChild, ElementRef, OnDestroy, OnInit} from "@angular/core";

import {FeedService} from "../../service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {Subscription} from "rxjs/Rx";
import {UINavigationObservable, ScrollEvent} from "../../../ui/service/navigation";

@Component({
    selector: 'cass-feed-scroll-detector',
    template: require('./template.jade')
})

export class FeedScrollDetector implements OnInit, OnDestroy
{
    private subscription: Subscription;

    @ViewChild('feedUpdateButton') feedUpdateButton: ElementRef;

    constructor(
        private navigator: UINavigationObservable,
        private feed: FeedService<PostEntity>
    ) {}

    ngOnInit() {
        this.subscription = this.navigator.scroll.subscribe((event: ScrollEvent) => {
            let testTumblrIsTriggered = () => { return event.scrollTotal - event.scrollBottom < 30 };
            let testIsNotFeedLoading = () => { return ! this.feed.isLoading(); };
            let testFeedHasMoreRecords = () => { return this.feed.hasMoreEntities(); };
            let testNearEnd = () => { return (event.scrollTotal - event.scrollTop) < (event.clientHeight + 50); };

            if(testTumblrIsTriggered() && testIsNotFeedLoading() && testFeedHasMoreRecords() && testNearEnd()) {
                this.feed.next();
            }
        });
    }

    ngOnDestroy() {
        this.subscription.unsubscribe();
    }
}