import {Component} from "@angular/core";

import {CollectionRouteHelper} from "../../helper";

@Component({
    selector: 'cass-public-collections-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PublicCollectionsMenu
{
    constructor(
        private helper: CollectionRouteHelper
    ) {}

    getThemesRoute() {
        return this.helper.generateThemesRoute();
    }

    getContentRoute() {
        return this.helper.generateContentsRoute();
    }
}