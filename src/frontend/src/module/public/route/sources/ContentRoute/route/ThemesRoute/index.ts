import {Component, ViewChild, ElementRef, OnInit} from "@angular/core";

import {ThemeRouteHelper} from "../../../../theme-route-helper";
import {CurrentThemeService} from "../../../../../../theme/service/CurrentThemeService";
import {ActivatedRoute} from "@angular/router";
import {Theme} from "../../../../../../theme/definitions/entity/Theme";
import {UIPathService} from "../../../../../../ui/path/service";

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
        private path: UIPathService,
    ) {
        helper.provideBaseURL('/p/home/themes');
        current.provideTheme(route);


        this.path.setPath([
            {name: 'Yoozer', route: ['/p/home']},
            {name: 'Тематики', route: ['/p/home/themes/']}
        ]);

        let collect: Theme[] = [];

        for(let theme of this.current.getPath()) {
            collect.push(theme);
            let route = ['/p/home/themes/'];

            for(let sub of collect) {
                route.push(sub.url);
            }

            this.path.pushPath({
                name: theme.title,
                route: route
            })
        }
    }

    goTheme(theme: Theme) {
        if(theme.children.length === 0) {
            this.helper.provideBaseURL('/p/home/content/all/');
        }

        this.helper.goTheme(theme);
    }
}