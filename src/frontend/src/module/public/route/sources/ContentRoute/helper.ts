import {Injectable} from "@angular/core";
import {Router} from "@angular/router";

import {ThemeRouteHelper} from "../../theme-route-helper";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ContentType} from "../../../../feed/definitions/request/criteria/ContentTypeCriteriaParams";

export enum CONTENT_ROUTE_MODE {
    Feed = <any>"feed",
    Themes = <any>"themes",
}

export interface ContentRouteHelperConfig
{
    mode: CONTENT_ROUTE_MODE;
    contentType: ContentType
}

@Injectable()
export class ContentRouteHelper
{
    public config: ContentRouteHelperConfig;

    constructor(
        public themes: ThemeRouteHelper,
        private router: Router,
    ) {}

    public setup(config: ContentRouteHelperConfig)
    {
        this.config = config;
    }

    goTheme(theme: Theme) {
        this.themes.setCurrentTheme(theme);

        if(this.config.mode === CONTENT_ROUTE_MODE.Feed) {
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
        this.config.mode = CONTENT_ROUTE_MODE.Themes;

        let route = ['/p/home/themes'];

        this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
            route.push(theme.url);
        });

        this.router.navigate(this.generateThemesRoute());
    }

    browseContent() {
        this.config.mode = CONTENT_ROUTE_MODE.Feed;

        this.router.navigate(this.generateContentsRoute());
    }

    generateThemesRoute() {
        let route = ['/p/home/themes'];

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }

    generateContentsRoute(type?: string) {
        let route = [`/p/home/content/all/`];


        if(type) {
            route = [`/p/home/content/${type}`];
        } else if(this.config !== undefined && this.config.contentType !== undefined) {
            route = [`/p/home/content/${this.config.contentType}`];
        }

        if(! this.themes.isRoot(this.themes.getCurrentTheme())) {
            this.themes.getThemePath(this.themes.getCurrentTheme()).forEach(theme => {
                route.push(theme.url);
            });
        }

        return route;
    }
}