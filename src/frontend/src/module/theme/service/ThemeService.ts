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
                children: []
            }
        }
    }

    getAll(): Array<Theme> {
        return this.themes;
    }
}