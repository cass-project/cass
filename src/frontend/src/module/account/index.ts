import {Component, Directive} from "@angular/core";

import {AccountDeleteWarning} from "./component/AccountDeleteWarning/index";

@Component({
    template: require('./template.jade'),
})
@Directive({selector: 'cass-account'})
export class AccountComponent
{
}