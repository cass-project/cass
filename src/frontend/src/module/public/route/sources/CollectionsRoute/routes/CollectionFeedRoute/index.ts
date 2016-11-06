import {Component} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {CollectionRouteHelper, COLLECTION_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {CollectionIndexEntity} from "../../../../../../collection/definitions/entity/collection";
import {FeedService} from "../../../../../../feed/service/FeedService/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionFeedRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: CollectionRouteHelper,
        private translation: TranslationService,
        private service: FeedService<CollectionIndexEntity>,
    ) {
        route.params.forEach(params => {
            let baseURL = '/p/collections/entities';

            this.helper.setup({
                mode: COLLECTION_ROUTE_MODE.Feed,
            });

            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate("cass.module.public.menu.collection.title"), route: [baseURL] },
            ]);

            this.helper.themes.generateUIPath();
            this.service.update();
        });
    }

}
