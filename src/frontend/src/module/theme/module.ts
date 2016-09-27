import {ThemeRESTService} from "./service/ThemeRESTservice";
import {ThemeService} from "./service/ThemeService";
import {ThemeSelect} from "./component/Elements/ThemeSelect/index";
import {ThemeBrowser} from "./component/Elements/ThemeBrowser/index";
import {THEME_CARD_DIRECTIVES} from "./component/Cards/ThemeCard/index";

export const CASSThemeModule = {
    declarations: [
        ThemeSelect,
        ThemeBrowser,
        THEME_CARD_DIRECTIVES,
    ],
    providers: [
        ThemeRESTService,
        ThemeService,
    ]
};