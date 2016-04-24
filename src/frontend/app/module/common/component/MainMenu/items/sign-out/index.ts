import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: "main-menu-item-sign-out",
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class MainMenuSignOutItem
{
    public getTitle(): string {
        return 'Sign Out';
    }

    public getDescription(): string {
        return 'Sign Out';
    }

    public getImageFA()
    {
        return 'fa fa-sign-out';
    }
}