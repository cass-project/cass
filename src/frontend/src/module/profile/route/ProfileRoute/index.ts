import {Component, OnInit, ElementRef, ViewChild, OnDestroy} from "@angular/core";
import {ActivatedRoute} from "@angular/router";
import {Subscription} from "rxjs/Rx";

import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {ProfileRouteService} from "./service";
import {UINavigationObservable} from "../../../ui/service/navigation";
import {UIService} from "../../../ui/service/ui";
import {Theme} from "../../../theme/definitions/entity/Theme";
import {ThemeService} from "../../../theme/service/ThemeService";
import {SwipeService} from "../../../swipe/service/SwipeService";
import {FeedService} from "../../../feed/service/FeedService/index";
import {PostIndexedEntity} from "../../../post/definitions/entity/Post";
import {PublicService} from "../../../public/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileRouteService,
        FeedCriteriaService,
        FeedOptionsService,
        FeedService,
        PublicService
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
        private ui: UIService,
        private criteria: FeedCriteriaService,
        private theme: ThemeService,
        private swipe: SwipeService,
        private feedService: FeedService<PostIndexedEntity>
    ) {}
    
    ngOnInit() {
        let elem = this.content.nativeElement;

        this.service.exportResponse(
            this.route.snapshot.data['profile']
        );

        this.subscriptions = [
            this.navigator.top.subscribe(() => {
                elem.scrollTop = 0;
            }),
            this.navigator.bottom.subscribe(() => {
                elem.scrollTop = elem.scrollHeight - elem.clientHeight;
            }),
        ];

        this.profile = this.service.getEntity();
    }

    ngOnDestroy() {
        this.subscriptions.forEach((subscription) => {
            subscription.unsubscribe();
        });
    }

    getThemeRoot(): Theme {
        let criteria = this.criteria.criteria.theme;

        if(criteria.enabled) {
            return this.theme.findById(criteria.params.id);
        }else{
            return this.theme.getRoot();
        }
    }

    getThemePanelRoot(): Theme {
        let criteria = this.criteria.criteria.theme;

        if(criteria.enabled) {
            let current = this.theme.findById(criteria.params.id);

            if(current.children !== undefined && current.children.length > 0) {
                return current;
            }else if(current.parent_id){
                return this.theme.findById(current.parent_id);
            }else{
                return this.theme.getRoot();
            }
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

        this.feedService.update();
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