import {Injectable} from "angular2/core";
import {FrontlineService} from "../../frontline/service";
import {ThemeTree, Theme} from "../Theme";

@Injectable()
export class ThemeService
{
    public themes: ThemeTree[];
    private themesSelectOptions: ThemeSelect[];
    
    constructor(private frontline: FrontlineService) {
        this.themes = frontline.session.themes;
    }

    public getThemeSelectOptions() {
        if(this.themesSelectOptions === undefined) {
            this.themesSelectOptions = this.generateThemeSelectOptions(this.themes);
        }

        return this.themesSelectOptions;
    }

    private generateThemeSelectOptions(tree: ThemeTree[], level: string = '', bindTo: Array<ThemeSelect> = []) {
        for(let theme of tree) {
            bindTo.push({
                id: theme.id,
                title: level + theme.title
            });

            if(theme.children) {
                this.generateThemeSelectOptions(theme.children, level + '. ', bindTo);
            }
        }

        return bindTo;
    }
}

export class ThemeSelect
{
    id: number;
    title: string;
}