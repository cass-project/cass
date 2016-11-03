import {Injectable} from "@angular/core";
import {ActivatedRoute} from "@angular/router";

import {ThemeService} from "./ThemeService";
import {Theme} from "../definitions/entity/Theme";

@Injectable()
export class CurrentThemeService
{
    private path: Theme[] = [];

    constructor(
        private service: ThemeService
    ) {}

    public provideTheme(route: ActivatedRoute) {
        this.path = [];

        return route.params.forEach(params => {
            let path: Theme[] = [];
            let root: Theme = this.service.getRoot();

            for(let lvl = 1; lvl <= 9; lvl++) {
                if(params['theme_lvl' + lvl] !== undefined) {
                    root = this.service.getThemeByURL(root, params['theme_lvl' + lvl]);
                    path.push(root);
                }
            }

            this.path = path;
        });
    }

    public getRoot(): Theme {
        return this.service.getRoot();
    }

    public hasCurrentTheme(): boolean {
        return this.path.length > 0;
    }

    public getCurrentTheme(): Theme {
        return this.path[this.path.length - 1];
    }

    public getPath(): Theme[] {
        return this.path;
    }
}

