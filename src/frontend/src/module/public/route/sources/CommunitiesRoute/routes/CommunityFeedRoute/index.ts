import {Component} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {CommunityRouteHelper, COMMUNITY_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {CommunityIndexedEntity} from "../../../../../../community/definitions/entity/Community";
import {FeedService} from "../../../../../../feed/service/FeedService/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityFeedRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: CommunityRouteHelper,
        private translation: TranslationService,
        private service: FeedService<CommunityIndexedEntity>,
    ) {
        route.params.forEach(params => {
            let baseURL = '/p/communities/entities';

            this.helper.setup({
                mode: COMMUNITY_ROUTE_MODE.Feed,
            });

            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate("cass.module.public.menu.community.title"), route: [baseURL] },
            ]);

            this.helper.themes.generateUIPath();
            this.service.update();
        });
    }

}
