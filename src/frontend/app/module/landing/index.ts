import {Component} from "angular2/core";
import {AuthComponent} from "../auth/component/Auth/index";
import {ProfileSetup} from "../profile/component/ProfileSetup/index";
import {ThemeSelect} from "../theme/component/ThemeSelect/index";

@Component({
    template: require('./template.html'),
    directives: [
        AuthComponent,
        ProfileSetup,
        ThemeSelect
    ]
})
export class LandingComponent {
    private devShowProfileSetup = false;
}