import {Component, OnInit, ElementRef, ViewChild, OnDestroy} from "@angular/core";
import {ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Rx";

import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {UINavigationObservable} from "../../../ui/service/navigation";
import {CommunityExtendedEntity} from "../../definitions/entity/CommunityExtended";
import {CommunityRouteService} from "./service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityRouteService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})

export class CommunityRoute implements OnInit, OnDestroy
{
    @ViewChild('content') private content: ElementRef;

    private community: CommunityExtendedEntity;
    private subscriptions: Subscription[];

    constructor(
        private route: ActivatedRoute,
        private service: CommunityRouteService,
        private navigator: UINavigationObservable
    ) {}

    ngOnInit() {
        let elem = this.content.nativeElement;

        this.service.exportResponse(
            this.route.snapshot.data['community']
        );

        this.subscriptions = [
            this.navigator.top.subscribe(() => {
                elem.scrollTop = 0;
            }),
            this.navigator.bottom.subscribe(() => {
                elem.scrollTop = elem.scrollHeight - elem.clientHeight;
            }),
        ];

        this.community = this.service.getEntity();
    }

    ngOnDestroy() {
        this.subscriptions.forEach((subscription) => {
            subscription.unsubscribe();
        });
    }

    isOwnCommunity() {
        return !!this.community && this.community.is_own;
    }

    isOtherCommunity() {
        return ! this.isOwnCommunity();
    }

    emitScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}