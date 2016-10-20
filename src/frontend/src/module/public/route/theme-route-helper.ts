import {Injectable} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";

import {Theme} from "../../theme/definitions/entity/Theme";
import {ThemeService} from "../../theme/service/ThemeService";
import {CurrentThemeService} from "../../theme/service/CurrentThemeService";

@Injectable()
export class ThemeRouteHelper
{
    private baseUrl: string;

    constructor(
        private themes: ThemeService,
        private router: Router,
        private route: ActivatedRoute,
        private current: CurrentThemeService
    ) {}

    provideBaseURL(baseUrl: string) {
        this.baseUrl = baseUrl;
    }

    goTheme(theme: Theme) {
        let path = this.themes.getPath(theme); path.pop();
        let route = [this.baseUrl];
        let p: Theme;

        while(p = path.pop()) {
            route.push(p.url);
        }

        this.router.navigate(route);
    }

    getThemePanelRoot(): Theme {
        if(this.current.hasCurrentTheme()) {
            let current = this.current.getCurrentTheme();

            if(current.children !== undefined && current.children.length > 0) {
                return current;
            }else if(current.parent_id){
                return this.themes.findById(current.parent_id);
            }else{
                return this.themes.getRoot();
            }
        }else{
            return this.getThemeRoot();
        }
    }

    getThemeRoot(): Theme {
        if(this.current.hasCurrentTheme()) {
            return this.current.getCurrentTheme();
        }else{
            return this.current.getRoot();
        }
    }
}