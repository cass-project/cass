import {Component} from "@angular/core";

import {AccountDeleteWarning} from "./component/AccountDeleteWarning/index";

@Component({
    selector: 'cass-account',
    template: require('./template.jade'),
    providers: [AccountDeleteWarning]
})
export class AccountComponent
{
}