import {Injectable} from "@angular/core";
import {Router} from "@angular/router";

import {ThemeRouteHelper} from "../../theme-route-helper";
import {Theme} from "../../../../theme/definitions/entity/Theme";

export enum COMMUNITY_ROUTE_MODE {
    Feed = <any>"feed",
    Themes = <any>"themes",
}

export interface CommunityRouteHelperConfig
{
    mode: COMMUNITY_ROUTE_MODE;
}

@Injectable()
export class CommunityRouteHelper
{
    public config: CommunityRouteHelperConfig;

    constructor(
        public themes: ThemeRouteHelper,
        private router: Router,
    ) {}

    public setup(config: CommunityRouteHelperConfig)
    {
        this.config = config;
    }

    goTheme(theme: Theme) {
        this.themes.setCurrentTheme(theme);

        if(this.config.mode === COMMUNITY_ROUTE_MODE.Feed) {
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
        this.config.mode = COMMUNITY_ROUTE_MODE.Themes;

        let route = ['/p/communities/themes'];

        this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
            route.push(theme.url);
        });

        this.router.navigate(this.generateThemesRoute());
    }

    browseContent() {
        this.config.mode = COMMUNITY_ROUTE_MODE.Feed;

        this.router.navigate(this.generateContentsRoute());
    }

    generateThemesRoute() {
        let route = ['/p/communities/themes'];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }

    generateContentsRoute() {
        let route = [`/p/communities/entities`];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }
}