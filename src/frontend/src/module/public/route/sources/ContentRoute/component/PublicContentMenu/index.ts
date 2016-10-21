import {Component, Input} from '@angular/core';

import {Router} from "@angular/router";
import {CurrentThemeService} from "../../../../../../theme/service/CurrentThemeService";


@Component({
    selector: 'cass-public-content-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PublicContentMenu
{
    @Input('is-extended') isExtended: boolean = false;

    constructor(
        private router: Router,
        private current: CurrentThemeService
    ) { }

    getThemesRoute() {
        let path = ['/p/home/themes'];

        this.current.getPath().forEach(theme => {
            path.push(theme.url);
        });

        return path;
    }

    getContentRoute(type: string) {
        let path = ['/p/home/content', type];

        this.current.getPath().forEach(theme => {
            path.push(theme.url);
        });

        return path;
    }
}