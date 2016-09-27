import {Component, ViewChild, ElementRef} from '@angular/core';

import {UIService} from "../../../service/ui";
import {Router} from "@angular/router";

@Component({
    selector: 'cass-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CASSHeader
{
    @ViewChild('searchBox') searchBox: ElementRef;

    constructor(
        private ui: UIService,
        private router: Router
    ) {}

    toggleSearch() {
        this.ui.panels.header.disable();
    }

    isOnProfile(): boolean {
        return this.router.isActive('/profile', false);
    }

    isOnCatalog(): boolean {
        return this.router.isActive('/home', false);
    }
}