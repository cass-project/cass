import {Component} from "angular2/core";

import {ThemeSelect} from "../../../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-profile-setup-screen-expert-in',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect
    ]
})
export class ProfileSetupScreenExpertIn
{
}