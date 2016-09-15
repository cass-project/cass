import {Component, Renderer} from "@angular/core";
import {AuthComponentService} from "./service";

@Component({
    selector: 'cass-auth',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class AuthComponent
{
    constructor(private service: AuthComponentService, renderer: Renderer) {
        renderer.listenGlobal('document', 'keyup', (event:KeyboardEvent) => {
            if (event.shiftKey && event.altKey && event.keyCode === 77 /* M */) {
                if (this.service.modals.authDev.isOpened()) {
                    this.service.closeAllModals();
                } else {
                    this.service.authDev();
                }
            }
        })
    }
}