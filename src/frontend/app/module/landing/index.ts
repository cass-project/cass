import {Component} from "angular2/core";
import {AuthComponent} from "../auth/component/Auth/index";

@Component({
    template: require('./template.html'),
    directives: [
        AuthComponent
    ]
})
export class LandingComponent {}