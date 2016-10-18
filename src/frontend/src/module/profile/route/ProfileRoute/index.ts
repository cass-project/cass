import {Component, OnInit, ElementRef, ViewChild, OnDestroy} from "@angular/core";
import {ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Rx";

import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {ProfileRouteService} from "./service";
import {UINavigationObservable} from "../../../ui/service/navigation";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileRouteService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})

export class ProfileRoute implements OnInit, OnDestroy
{
    @ViewChild('content') private content: ElementRef;

    private profile: ProfileExtendedEntity;
    private subscriptions: Subscription[];

    constructor(
        private route: ActivatedRoute,
        private service: ProfileRouteService,
        private navigator: UINavigationObservable
    ) {}
    
    ngOnInit() {
        let elem = this.content.nativeElement;

        this.service.exportResponse(
            this.route.snapshot.data['profile']
        );
            
        this.navigator.initNavigation(this.content);
        
        this.profile = this.service.getEntity();
    }

    ngOnDestroy() {
        this.navigator.destroyNavigation();
    }

    isOwnProfile() {
        return !!this.profile && this.profile.is_own;
    }

    isOtherProfile() {
        return ! this.isOwnProfile();
    }

    emitScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}