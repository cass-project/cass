import {Component} from "angular2/core";
import {AuthComponent} from "../auth/component/Auth/index";
import {ProfileSetup} from "../profile/component/ProfileSetup/index";

@Component({
    template: require('./template.html'),
    directives: [
        AuthComponent,
        ProfileSetup,
    ]
})
export class LandingComponent {
    private devShowProfileSetup = false;
}