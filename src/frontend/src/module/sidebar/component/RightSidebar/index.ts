import {Component} from "@angular/core";

import {ViewOptionService} from "../../../public/component/Options/ViewOption/service";
import {ContentPlayerService} from "../../../player/service/ContentPlayerService";
import {NavigationObservable} from "../../../navigator/service/NavigationObservable";

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
        private viewOption: ViewOptionService,
        private player: ContentPlayerService,
        private navigator: NavigationObservable
    ) {}
}