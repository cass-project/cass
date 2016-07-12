import {Component} from "angular2/core";

import {ProfileIMTextarea} from "../ProfileIMTextarea/index";


@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileIMTextarea
    ]
})

export class ProfileIMMessages
{
}
