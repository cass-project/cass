import {Injectable} from "@angular/core";

import {Theme} from "../definitions/entity/Theme";
import {FrontlineService} from "../../frontline/service/FrontlineService";

@Injectable()
export class ThemeService
{
    root: Theme;
    themes: Theme[];
    themesMap = {};

    constructor(private frontlineService: FrontlineService) {
        this.themes = frontlineService.session.themes;

        var convertTreeToMap = (themes: Array<Theme>) => {
            for(let tree of themes) {
                this.themesMap[tree.id.toString()] = tree;

                if(tree.description.length === 0) {
                    tree.description = tree.title;
                }

                if(tree.children.length) {
                    convertTreeToMap(tree.children);
                }
            }
        };

        convertTreeToMap(this.themes);
    }

    each(fn: { (theme: Theme) }) {
        for(let n in this.themesMap) {
            if(this.themesMap.hasOwnProperty(n)) {
                fn(this.themesMap[n]);
            }
        }
    }

    hasWithId(themeId: number): boolean {
        return this.themesMap.hasOwnProperty(themeId.toString());
    }

    findById(themeId: number): Theme {
        if(this.themesMap.hasOwnProperty(themeId.toString())) {
            return this.themesMap[themeId.toString()];
        }else{
            throw new Error(`Theme '${themeId}' not found`);
        }
    }

    getThemesNoFault(themeIds: number[]): Theme[] {
        let result = [];

        for(let id of themeIds) {
            if(this.hasWithId(id)) {
                result.push(this.findById(id));
            }
        }

        return result;
    }

    getThemeByURL(root: Theme, url: string): Theme {
        for(let theme of root.children) {
            if(theme.url === url) {
                return theme;
            }
        }

        throw new Error(`Theme with URL "${url}" not found`);
    }

    getPath(root: Theme): Theme[] {
        let path = [root];

        while(root.parent_id) {
            root = this.findById(root.parent_id);

            path.push(root);
        }

        return path;
    }

    getRoot(): Theme {
        if(this.themes.length > 0) {
            return this.themes[0];
        }else{
            return {
                id: 1,
                title: 'Yoozer',
                description: 'Yoozer',
                parent_id: null,
                position: 1,
                preview: '',
                url: '',
                children: []
            }
        }
    }

    getAll(): Array<Theme> {
        return this.themes;
    }
}
