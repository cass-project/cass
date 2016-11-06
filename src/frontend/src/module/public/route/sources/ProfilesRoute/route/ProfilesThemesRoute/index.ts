import {Component, OnInit} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {PublicProfilesRouteHelper, PROFILES_ROUTE_MODE} from "../../helper";
import {PublicProfilesSources} from "../../../../../../feed/service/FeedService/source/public/PublicProfilesSource";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ProfilesThemesRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: PublicProfilesRouteHelper,
        private translation: TranslationService
    ) {
        this.helper.setup({
            mode: PROFILES_ROUTE_MODE.Themes,
            source: PublicProfilesSources.InterestingIn,
        });

        route.params.forEach(params => {
            this.helper.themes.setCurrentThemeFromParams(params);
            this.helper.themes.setBasePath([
                { name: this.translation.translate('cass.module.public.menu.people.title'), route: ['/p/people'] },
                { name: this.translation.translate('themes'), route: ['/p/people/themes'] },
            ]);
            this.helper.themes.generateUIPath();
        });
    }
}