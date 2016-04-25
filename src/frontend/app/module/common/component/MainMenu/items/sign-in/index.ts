import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: "main-menu-item-sign-in",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class MainMenuSignInItem
{
    public getTitle(): string {
        return 'Sign In';
    }

    public getDescription(): string {
        return 'Sign in to unlock more features!';
    }

    public getImageFA()
    {
        return 'fa fa-sign-in';
    }
}