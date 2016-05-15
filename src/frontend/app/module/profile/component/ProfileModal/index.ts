import {Component} from "angular2/core";

import {ProfilesList} from "../ProfilesList/index";
import {ProfileImage} from "../ProfileImage/index";

@Component({
    selector: 'cass-profile-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfilesList,
        ProfileImage,
    ]
})
export class ProfileModal
{
}