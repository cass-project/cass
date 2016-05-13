import {Component} from "angular2/core";
import {ProfileGreetingsSettings} from "../ProfileGreetingsSettings/index";
import {ProfileImageSettings} from "../ProfileImageSettings/index";
import {ProfileInterestSettings} from "../ProfileInterestsSettings/index";

@Component({
    selector: 'cass-profile-setup',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileGreetingsSettings,
        ProfileImageSettings,
        ProfileInterestSettings
    ]
})
export class ProfileSetup
{
}