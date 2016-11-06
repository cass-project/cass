import {Component} from "@angular/core";
import {PublicProfilesRouteHelper} from "../../helper";

@Component({
    selector: 'cass-public-profiles-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PublicProfilesMenu
{
    constructor(
        private helper: PublicProfilesRouteHelper,
    ) {}

    getThemesRoute() {
        return this.helper.generateThemesRoute();
    }

    getProfilesRoute() {
        return this.helper.generateProfilesRoute();
    }

    getExpertsRoute() {
        return this.helper.generateExpertsRoute();
    }
}