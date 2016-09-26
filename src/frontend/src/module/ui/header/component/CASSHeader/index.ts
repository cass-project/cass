import {Component, ViewChild, ElementRef, OnInit} from '@angular/core';
import {UIService} from "../../../service/ui";

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
        private ui: UIService
    ) {}

    toggleSearch() {
        this.ui.panels.header.disable();
    }
}