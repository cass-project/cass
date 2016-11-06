import {ActivatedRoute} from "@angular/router";
import {Component} from "@angular/core";

import {CommunityRouteHelper, COMMUNITY_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CommunityThemesRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: CommunityRouteHelper,
        private translation: TranslationService
    ) {
        this.helper.setup({
            mode: COMMUNITY_ROUTE_MODE.Themes,
        });

        route.params.forEach(params => {
            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate("cass.module.public.menu.community.title"), route: ['/p/communities'] },
                { name: this.translation.translate('themes'), route: ['/p/communities/themes'] },
            ]);
            this.helper.themes.generateUIPath();
        });
    }
}