import {Component, ViewChild, ElementRef, OnInit} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {FeedService} from "../../../../../../feed/service/FeedService/index";
import {PostIndexedEntity, PostEntity} from "../../../../../../post/definitions/entity/Post";
import {UINavigationObservable} from "../../../../../../ui/service/navigation";
import {CollectionEntity} from "../../../../../../collection/definitions/entity/collection";
import {PostTypeEntity} from "../../../../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../../../../post/service/PostTypeService";
import {Session} from "../../../../../../session/Session";
import {CurrentThemeService} from "../../../../../../theme/service/CurrentThemeService";
import {ThemeRouteHelper} from "../../../../theme-route-helper";
import {FeedCriteriaService} from "../../../../../../feed/service/FeedCriteriaService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]

})
export class ContentRoute implements OnInit
{
    @ViewChild('content') content: ElementRef;

    private postType: PostTypeEntity;

    constructor(
        private route: ActivatedRoute,
        private current: CurrentThemeService,
        private session: Session,
        private service: FeedService<PostIndexedEntity>,
        private navigator: UINavigationObservable,
        private types: PostTypeService,
        private feed: FeedService<PostEntity>,
        private helper: ThemeRouteHelper,
        private criteria: FeedCriteriaService,
    ) {
        route.params.forEach(params => {
            let contentType =  params['type'];

            helper.provideBaseURL('/p/home/content/' + contentType);

            if(contentType === 'all') {
                this.criteria.criteria.contentType.enabled = false;
            }else{
                this.criteria.criteria.contentType.enabled = true;
                this.criteria.criteria.contentType.params.type = contentType;
            }

            current.provideTheme(route);
            service.update();
        });

        this.postType = this.types.getTypeByStringCode('default');
    }

    ngOnInit() {
        this.navigator.initNavigation(this.content);
    }

    ngOnDestroy(){
        this.navigator.destroyNavigation();
    }

    unshiftEntity(entity: PostEntity) {
        this.feed.stream.insertBefore(entity);
    }

    getMainCollection(): CollectionEntity {
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