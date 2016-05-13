import {Component} from "angular2/core";

import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-profile-settings-interests',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect
    ]
})
export class ProfileSettingsInterests
{
}