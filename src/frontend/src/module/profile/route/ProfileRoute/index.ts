import {ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Rx";
import {Component, OnInit, ElementRef, ViewChild, OnDestroy} from "@angular/core";

import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {ProfileRouteService} from "./service";
import {UINavigationObservable} from "../../../ui/service/navigation";
import {UIPathService} from "../../../ui/path/service";
import {ProfileSubscriptionsHelper} from "../../../profile-subscriptions/routes/helper";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileRouteService,
        FeedCriteriaService,
        FeedOptionsService,
        ProfileSubscriptionsHelper,
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
        private navigator: UINavigationObservable,
        private helper: ProfileSubscriptionsHelper,
        private path: UIPathService
    ) {
        path.setPath([{
            name: 'Профиль',
            route: ['/profile']
        }]);
    }
    
    ngOnInit() {
        let elem = this.content.nativeElement;

        this.service.exportResponse(
            this.route.snapshot.data['profile']
        );
            
        this.navigator.initNavigation(this.content);
        this.helper.current = this.service.getEntity();
        
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