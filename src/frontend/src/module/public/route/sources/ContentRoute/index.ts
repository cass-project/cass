import {Component, ViewChild, ElementRef, OnInit} from "@angular/core";

import {FeedService} from "../../../../feed/service/FeedService/index";
import {PublicContentSource} from "../../../../feed/service/FeedService/source/public/PublicContentSource";
import {Stream} from "../../../../feed/service/FeedService/stream";
import {PublicService} from "../../../service";
import {PostIndexedEntity, PostEntity} from "../../../../post/definitions/entity/Post";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {UIService} from "../../../../ui/service/ui";
import {UINavigationObservable} from "../../../../ui/service/navigation";
import {SwipeService} from "../../../../swipe/service/SwipeService";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../../post/service/PostTypeService";
import {Session} from "../../../../session/Session";

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
        FeedOptionsService
    ]
})
export class ContentRoute implements OnInit
{
    @ViewChild('content') content: ElementRef;

    private postType: PostTypeEntity;

    constructor(
        private session: Session,
        private catalog: PublicService,
        private service: FeedService<PostIndexedEntity>,
        private source: PublicContentSource,
        private ui: UIService,
        private navigator: UINavigationObservable,
        private swipe: SwipeService,
        private theme: ThemeService,
        private criteria: FeedCriteriaService,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>
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

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
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

    getMainCollection(): CollectionEntity {
        this.postType = this.types.getTypeByStringCode('default');

        for(let collection of this.session.getCurrentProfile().entity.collections) {
            if (collection.is_main) {
                return collection;
            }
        }

        throw new Error('No main collection found');
    }

    canPost(): boolean {
        return this.session.isSignedIn();
    }

    onScroll($event) {
        this.navigator.emitScroll(this.content);
    }
}