import {Component} from "angular2/core";
import {ProfileSetupModel} from "../../model";
import {ThemeSelect} from "../../../../../theme/component/ThemeSelect/index";


@Component({
    selector: 'cass-profile-setup-screen-interests',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect,
    ]
})
export class ProfileSetupScreenInterests
{
    constructor(private model: ProfileSetupModel){}
}