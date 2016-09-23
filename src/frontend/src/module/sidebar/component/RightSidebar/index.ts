import {Component} from "@angular/core";

import {ViewOptionService} from "../../../public/component/Options/ViewOption/service";

@Component({
    selector: 'cass-right-sidebar',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class RightSidebar
{
    constructor(
        private viewOption: ViewOptionService
    ) {}
}