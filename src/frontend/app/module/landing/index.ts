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
    private themeIds = [16,17,18,19];

    updateThemeIds($event) {
        console.log('updateThemeIds', $event);
    }
}