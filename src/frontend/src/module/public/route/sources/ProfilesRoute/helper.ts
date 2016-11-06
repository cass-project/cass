import {Router} from "@angular/router";
import {Injectable} from "@angular/core";

import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ThemeRouteHelper} from "../../theme-route-helper";
import {PublicProfilesSources} from "../../../../feed/service/FeedService/source/public/PublicProfilesSource";

export enum PROFILES_ROUTE_MODE {
    Feed = <any>"feed",
    Themes = <any>"themes"
};

export interface PublicProfilesRouteHelperConfig
{
    mode: PROFILES_ROUTE_MODE;
    source: PublicProfilesSources
}

@Injectable()
export class PublicProfilesRouteHelper
{
    public config: PublicProfilesRouteHelperConfig;

    constructor(
        public themes: ThemeRouteHelper,
        private router: Router,
    ) {}

    public setup(config: PublicProfilesRouteHelperConfig)
    {
        this.config = config;
    }

    goTheme(theme: Theme) {
        this.themes.setCurrentTheme(theme);

        if(this.config.mode === PROFILES_ROUTE_MODE.Feed) {
            this.browseContent();
        }else{
            if(this.themes.getCurrentTheme().children.length > 0) {
                this.browseTheme();
            }else{
                this.browseContent();
            }
        }
    }

    browseTheme() {
        this.config.mode = PROFILES_ROUTE_MODE.Themes;

        let route = ['/p/people/themes'];

        this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
            route.push(theme.url);
        });

        this.router.navigate(this.generateThemesRoute());
    }

    browseContent() {
        this.config.mode = PROFILES_ROUTE_MODE.Feed;

        if(this.config.source === PublicProfilesSources.Experts) {
            this.router.navigate(this.generateExpertsRoute());
        }else{
            this.router.navigate(this.generateProfilesRoute());
        }
    }

    generateThemesRoute() {
        let route = ['/p/people/themes'];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }

    generateProfilesRoute() {
        let route = ['/p/people/s/profiles'];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }

    generateExpertsRoute() {
        let route = ['/p/people/s/experts'];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }
}
