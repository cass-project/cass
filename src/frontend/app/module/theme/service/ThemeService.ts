import {Injectable} from 'angular2/core';

import {FrontlineService} from "../../frontline/service";
import {Theme} from "../definitions/entity/Theme";
import {ThemeSelect} from "../component/ThemeSelect/index";

@Injectable()
export class ThemeService
{
    root: Theme;
    themes: Theme[];
    themesMap = {};

    
    constructor(public frontlineService: FrontlineService) {
        this.themes = frontlineService.session.themes;

        var convertTreeToMap = (themes: Array<Theme>) => {
            for(let tree of themes) {
                this.themesMap[tree.id.toString()] = tree;

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

    findById(themeId: number): Theme {
        if(this.themesMap.hasOwnProperty(themeId.toString())) {
            return this.themesMap[themeId.toString()];
        }else{
            throw new Error(`Theme '${themeId}' not found`);
        }
    }

    getRoot(): Theme {
        return {
            id: 0,
            parent_id: 0,
            position: 0,
            title: 'ROOT',
            description: 'ROOT Dir',
            children: this.themes
        };
    }

    getAll(): Array<Theme> {
        return this.themes;
    }
}