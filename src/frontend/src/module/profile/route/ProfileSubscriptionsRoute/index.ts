import {Component} from "@angular/core";
import {ProfileRouteService} from "../ProfileRoute/service";


@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSubscriptionsRoute
{
    constructor(
        private service: ProfileRouteService
    ) {}
}