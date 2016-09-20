import {Component, Renderer} from "@angular/core";
import {AuthModalsService} from "./modals";

@Component({
    selector: 'cass-auth',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class AuthComponent
{
    constructor(private modals: AuthModalsService) {}
}