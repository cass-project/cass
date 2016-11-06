import {Injectable} from "@angular/core";
import {Router, ActivatedRoute} from "@angular/router";

import {Theme} from "../../theme/definitions/entity/Theme";
import {ThemeService} from "../../theme/service/ThemeService";
import {UIPathService, UIPathItem} from "../../ui/path/service";
import {FeedCriteriaService} from "../../feed/service/FeedCriteriaService";

@Injectable()
export class ThemeRouteHelper
{
    private current: Theme;
    private basePaths: UIPathItem[];

    constructor(
        private themes: ThemeService,
        private router: Router,
        private route: ActivatedRoute,
        private uiPathService: UIPathService,
        private criteria: FeedCriteriaService,
    ) {}

    getCurrentTheme(): Theme {
        if(! this.current) {
            return this.themes.getRoot();
        }else{
            return this.current;
        }
    }

    setCurrentTheme(theme: Theme) {
        this.current = theme;

        if(this.isRoot(theme)) {
            this.criteria.criteria.theme.enabled = false;
        }else{
            this.criteria.criteria.theme.enabled = true;
            this.criteria.criteria.theme.params.id = theme.id;
        }
    }

    setCurrentThemeFromParams(params) {
        let current = this.themes.getRoot();

        for(let lvl = 1; lvl <= 9; lvl++) {
            if(params['theme_lvl' + lvl] !== undefined) {
                current = this.themes.getThemeByURL(current || this.themes.getRoot(), params['theme_lvl' + lvl]);
            }
        }

        this.setCurrentTheme(current);
    }

    setBasePath(paths: UIPathItem[]) {
        this.basePaths = paths;
    }

    getBaseURL(): Array<any> {
        return JSON.parse(JSON.stringify(this.basePaths[this.basePaths.length - 1].route));
    }

    getBasePaths(): UIPathItem[] {
        return this.basePaths;
    }

    generateUIPath() {
        let current = this.current;

        if(this.basePaths) {
            this.uiPathService.setPath(this.getBasePaths());
        }else{
            this.uiPathService.setPath([]);
        }

        let collect = this.getBaseURL();
        let path = this.getThemePath(current);

        for(let theme of path) {
            collect.push(theme.url);

            this.uiPathService.pushPath({
                name: theme.title,
                route: JSON.parse(JSON.stringify(collect)),
            })
        }
    }

    isRoot(theme: Theme) {
        return theme.id === this.themes.getRoot().id;
    }

    getThemePanelRoot(): Theme {
        if(this.current) {
            let current = this.current;

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
        if(this.current) {
            return this.current;
        }else{
            return this.themes.getRoot();
        }
    }

    getThemePath(theme: Theme): Theme[] {
        let paths = this.themes.getPath(theme);
            paths.pop();

        paths.reverse();

        return paths;
    }
}