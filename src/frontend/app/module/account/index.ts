import {Component} from "angular2/core";
import {AccountDeleteWarning} from "./component/AccountDeleteWarning/index";

@Component({
    selector: 'cass-account',
    template: require('./template.html'),
    directives: [
        AccountDeleteWarning
    ]
})
export class AccountComponent
{
}