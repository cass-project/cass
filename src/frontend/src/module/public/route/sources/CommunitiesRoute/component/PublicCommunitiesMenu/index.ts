import {Component} from "@angular/core";

import {CommunityRouteHelper} from "../../helper";

@Component({
    selector: 'cass-public-communities-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PublicCommunitiesMenu
{
    constructor(
        private helper: CommunityRouteHelper
    ) {}

    getThemesRoute() {
        return this.helper.generateThemesRoute();
    }

    getContentRoute() {
        return this.helper.generateContentsRoute();
    }
}