import {ThemeRESTService} from "./service/ThemeRESTservice";
import {ThemeService} from "./service/ThemeService";
import {ThemeSelect} from "./component/Elements/ThemeSelect/index";
import {ThemeBrowser} from "./component/Elements/ThemeBrowser/index";
import {THEME_CARD_DIRECTIVES} from "./component/Cards/ThemeCard/index";
import {ThemePath} from "./component/Elements/ThemePath/index";
import {ThemePanel} from "./component/Elements/ThemePanel/index";
import {ThemeHeader} from "./component/Elements/ThemeHeader/index";

export const CASSThemeModule = {
    declarations: [
        ThemeSelect,
        ThemeBrowser,
        THEME_CARD_DIRECTIVES,
        ThemePath,
        ThemePanel,
        ThemeHeader,
    ],
    providers: [
        ThemeRESTService,
        ThemeService,
    ]
};