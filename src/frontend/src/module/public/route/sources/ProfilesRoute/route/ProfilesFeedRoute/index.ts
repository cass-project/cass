import {ActivatedRoute} from "@angular/router";
import {Component, ViewChild, ElementRef} from "@angular/core";

import {
    PublicProfilesSource,
    PublicProfilesSources
} from "../../../../../../feed/service/FeedService/source/public/PublicProfilesSource";
import {UINavigationObservable} from "../../../../../../ui/service/navigation";
import {PublicProfilesRouteHelper, PROFILES_ROUTE_MODE} from "../../helper";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";
import {FeedService} from "../../../../../../feed/service/FeedService/index";
import {ProfileIndexedEntity} from "../../../../../../profile/definitions/entity/Profile";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfilesFeedRoute
{
    constructor(
        private route: ActivatedRoute,
        private navigator: UINavigationObservable,
        private helper: PublicProfilesRouteHelper,
        private source: PublicProfilesSource,
        private translation: TranslationService,
        private service: FeedService<ProfileIndexedEntity>,
    ) {
        route.params.forEach(params => {
            if(params['source'] === 'experts') {
                this.helper.setup({
                    mode: PROFILES_ROUTE_MODE.Feed,
                    source: PublicProfilesSources.Experts,
                });

                this.source.switchToExperts();
                this.helper.themes.setCurrentThemeFromParams(params);
                this.helper.themes.setBasePath([
                    { name: this.translation.translate('cass.module.public.menu.people.title'), route: ['/p/people'] },
                    { name: this.translation.translate('cass.module.public.menu.people.experts.title'), route: ['/p/people/s/experts'] },
                ]);
            }else{
                this.helper.setup({
                    mode: PROFILES_ROUTE_MODE.Feed,
                    source: PublicProfilesSources.InterestingIn,
                });
                this.source.switchToInterestingIn();
                this.helper.themes.setCurrentThemeFromParams(params);
                this.helper.themes.setBasePath([
                    { name: this.translation.translate('cass.module.public.menu.people.title'), route: ['/p/people'] },
                    { name: this.translation.translate('cass.module.public.menu.people.profiles.title'), route: ['/p/people/s/profiles'] },
                ]);
            }

            this.helper.themes.generateUIPath();
            this.service.update();
        });
    }
}