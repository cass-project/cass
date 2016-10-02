import {Component, ElementRef, ViewChild} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PublicProfilesSource} from "../../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {ProfileEntity, ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";
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
        PublicProfilesSource,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
export class ProfilesRoute
{
    @ViewChild('content') content: ElementRef;

    constructor(
        private catalog: PublicService,
        private service: FeedService<ProfileIndexedEntity>,
        private source: PublicProfilesSource,
        private ui: UIService,
        private navigator: UINavigationObservable,
        private swipe: SwipeService,
        private theme: ThemeService,
        private criteria: FeedCriteriaService
    ) {
        catalog.source = 'profiles';
        catalog.injectFeedService(service);
        
        service.provide(source, new Stream<ProfileIndexedEntity>());
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

        this.service.update();
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}