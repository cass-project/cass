import {Component, ViewEncapsulation} from "angular2/core";
import {AuthService} from '../../../../../auth/service/AuthService';
import {Profile} from "../../../../../profile/entity/Profile";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({ // 1
    selector: "main-menu-item-browse",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class MainMenuBrowseItem
{
    public getTitle(): string {
        return 'Browse';
    }

    public getDescription(): string {
        return "Search for content, people and communities";
    }

    public getImageFA() {
        return 'fa fa-globe';
    }
}