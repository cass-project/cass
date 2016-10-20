import {Component, ViewChild, ElementRef, OnInit} from "@angular/core";

import {ThemeRouteHelper} from "../../../../theme-route-helper";
import {CurrentThemeService} from "../../../../../../theme/service/CurrentThemeService";
import {ActivatedRoute} from "@angular/router";
import {Theme} from "../../../../../../theme/definitions/entity/Theme";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemesRoute
{
    constructor(
        private route: ActivatedRoute,
        private helper: ThemeRouteHelper,
        private current: CurrentThemeService,
    ) {
        helper.provideBaseURL('/p/home/themes');
        current.provideTheme(route);
    }

    goTheme(theme: Theme) {
        if(theme.children.length === 0) {
            this.helper.provideBaseURL('/p/home/content/all/');
        }

        this.helper.goTheme(theme);
    }
}