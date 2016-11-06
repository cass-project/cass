import {Component} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {FeedService} from "../../../../../../feed/service/FeedService/index";
import {PostIndexedEntity} from "../../../../../../post/definitions/entity/Post";
import {FeedCriteriaService} from "../../../../../../feed/service/FeedCriteriaService";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {PublicContentSource} from "../../../../../../feed/service/FeedService/source/public/PublicContentSource";
import {ContentRouteHelper, CONTENT_ROUTE_MODE} from "../../helper";
import {CollectionEntity} from "../../../../../../collection/definitions/entity/collection";
import {Session} from "../../../../../../session/Session";
import {PostTypeEntity} from "../../../../../../post/definitions/entity/PostType";
import {PostTypeService} from "../../../../../../post/service/PostTypeService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]

})
export class ContentFeedRoute
{
    private postType: PostTypeEntity;

    constructor(
        private route: ActivatedRoute,
        private helper: ContentRouteHelper,
        private source: PublicContentSource,
        private translation: TranslationService,
        private service: FeedService<PostIndexedEntity>,
        private criteria: FeedCriteriaService,
        private session: Session,
        private types: PostTypeService,
    ) {
        this.postType = this.types.getTypeByStringCode('default');

        route.params.forEach(params => {
            let contentType =  params['type'];
            let baseURL = '/p/home/content/' + contentType;

            if(contentType === 'all') {
                this.criteria.criteria.contentType.enabled = false;
            }else{
                this.criteria.criteria.contentType.enabled = true;
                this.criteria.criteria.contentType.params.type = contentType;
            }

            this.helper.setup({
                mode: CONTENT_ROUTE_MODE.Feed,
                contentType: contentType,
            });

            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate(`sidebar.item.home.title`), route: ['/p/home'] },
                { name: this.translation.translate(`cass.module.public.content-type.${contentType}.title`), route: [baseURL] },
            ]);

            this.helper.themes.generateUIPath();
            this.service.update();
        });
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
}