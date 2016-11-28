import {Component, OnInit} from "@angular/core";

import {PersonalCollectionsSource} from "../../../../feed/service/FeedService/source/personal/PersonalCollectionsSource";
import {PostEntity} from "../../../../post/definitions/entity/Post";
import {FeedService} from "../../../../feed/service/FeedService/index";
import {ProfileSubscriptionsHelper} from "../../helper";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {Stream} from "../../../../feed/service/FeedService/stream";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./../subscriptions.shadow.scss'),
    ],
    providers: [
        FeedService,
        PersonalCollectionsSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class SubscriptionsCollectionsRoute implements OnInit
{
    constructor(
        private helper: ProfileSubscriptionsHelper,
        private feedSource: PersonalCollectionsSource,
        private feed: FeedService<PostEntity>,
    ) {}

    ngOnInit(): void {
        this.feed.provide(this.feedSource, new Stream<PostEntity>());
        this.feed.update();
    }
}