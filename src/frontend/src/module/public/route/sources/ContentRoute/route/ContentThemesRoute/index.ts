import {Component} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {ContentRouteHelper, CONTENT_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {ContentType} from "../../../../../../feed/definitions/request/criteria/ContentTypeCriteriaParams";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentThemesRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: ContentRouteHelper,
        private translation: TranslationService
    ) {
        this.helper.setup({
            mode: CONTENT_ROUTE_MODE.Themes,
            contentType: ContentType.All,
        });

        route.params.forEach(params => {
            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate(`sidebar.item.home.title`), route: ['/p/home'] },
                { name: this.translation.translate('themes'), route: ['/p/home/themes'] },
            ]);
            this.helper.themes.generateUIPath();
        });
    }
}