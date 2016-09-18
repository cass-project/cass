import {NgModule} from '@angular/core';

import {ThemeRESTService} from "./service/ThemeRESTservice";
import {ThemeService} from "./service/ThemeService";
import {ThemeSelect} from "./component/ThemeSelect/index";

@NgModule({
    declarations: [
        ThemeSelect,
    ],
    providers: [
        ThemeRESTService,
        ThemeService,
    ]
})
export class CASSThemeModule {}