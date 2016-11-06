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
import {UIPathService} from "../../../../../../ui/path/service";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {Theme} from "../../../../../../theme/definitions/entity/Theme";

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
        private path: UIPathService,
        private translate: TranslationService,
    ) {
        route.params.forEach(params => {
            let contentType =  params['type'];

            current.provideTheme(route);
            // helper.provideBaseURL('/p/home/content/' + contentType);

            if(contentType === 'all') {
                this.criteria.criteria.contentType.enabled = false;
            }else{
                this.criteria.criteria.contentType.enabled = true;
                this.criteria.criteria.contentType.params.type = contentType;
            }

            this.path.setPath([
                {name: 'Yoozer', route: ['/p/home']},
                {name: translate.translate(`cass.module.public.content-type.${contentType}.title`), route: ['/p/home/content/' + contentType]}
            ]);

            let collect: Theme[] = [];

            for(let theme of this.current.getPath()) {
                collect.push(theme);
                let route = ['/p/home/content/' + contentType];

                for(let sub of collect) {
                    route.push(sub.url);
                }

                this.path.pushPath({
                    name: theme.title,
                    route: route
                })
            }

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