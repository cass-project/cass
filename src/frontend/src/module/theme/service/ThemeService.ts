import {Injectable} from "@angular/core";
import {FrontlineService} from "../../frontline/service";
import {Theme} from "../definitions/entity/Theme";

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
        if(this.themes.length > 0) {
            return this.themes[0];
        }else{
            return {
                id: 1,
                title: 'ROOT',
                description: 'Root',
                parent_id: null,
                position: 1,
                children: []
            }
        }
    }

    getAll(): Array<Theme> {
        return this.themes;
    }
}