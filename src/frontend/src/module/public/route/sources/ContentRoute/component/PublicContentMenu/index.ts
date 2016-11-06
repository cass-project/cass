import {Component, Input} from '@angular/core';

import {Router} from "@angular/router";
import {CurrentThemeService} from "../../../../../../theme/service/CurrentThemeService";
import {ContentRouteHelper} from "../../helper";


@Component({
    selector: 'cass-public-content-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PublicContentMenu
{
    constructor(
        private router: Router,
        private current: CurrentThemeService,
        private helper: ContentRouteHelper,
    ) { }

    getThemesRoute() {
        return this.helper.generateThemesRoute();
    }

    getContentRoute(type: string) {
        return this.helper.generateContentsRoute(type);
    }
}