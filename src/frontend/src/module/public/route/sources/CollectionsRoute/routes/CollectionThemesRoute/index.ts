import {ActivatedRoute} from "@angular/router";
import {Component} from "@angular/core";

import {CollectionRouteHelper, COLLECTION_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CollectionThemesRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: CollectionRouteHelper,
        private translation: TranslationService
    ) {
        this.helper.setup({
            mode: COLLECTION_ROUTE_MODE.Themes,
        });

        route.params.forEach(params => {
            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate("cass.module.public.menu.collection.title"), route: ['/p/collections'] },
                { name: this.translation.translate('themes'), route: ['/p/collections/themes'] },
            ]);
            this.helper.themes.generateUIPath();
        });
    }
}