import {ThemeRESTService} from "./service/ThemeRESTservice";
import {ThemeService} from "./service/ThemeService";
import {ThemeSelect} from "./component/ThemeSelect/index";

export const CASSThemeModule = {
    declarations: [
        ThemeSelect,
    ],
    providers: [
        ThemeRESTService,
        ThemeService,
    ]
};