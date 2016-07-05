import {Component} from "angular2/core";

import {ProfileHeader} from "../../component/Elements/ProfileHeader/index";
import {ProfileCardsList} from "../../component/Elements/ProfileCardsList/index";
import {ProfileRouteService} from "../ProfileRoute/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileCardsList,
    ]
})
export class ProfileDashboardRoute
{
    constructor(private service: ProfileRouteService) {}
}