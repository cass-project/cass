import {Component, Output, EventEmitter, Renderer} from "@angular/core";

import {AuthService} from "../../service/AuthService";
import {AuthModalsService} from "../Auth/modals";

@Component({
    selector: 'cass-auth-sign-in-by-api-key',
    template: require('./template.jade')
})

export class SignInByAPIKeyComponent
{
    constructor(
        private auth: AuthService, renderer: Renderer,
        private modals: AuthModalsService,
    ) {
        renderer.listenGlobal('document', 'keyup', (event:KeyboardEvent) => {
            if (event.shiftKey && event.altKey && event.keyCode === 77 /* M */) {
                if (this.modals.authDev.isOpened()) {
                    this.modals.closeAllModals();
                } else {
                    this.modals.authDev();
                }
            }
        });
    }

    @Output('close') close = new EventEmitter<boolean>();
    @Output('error') error = new EventEmitter();
    
    private apiKey: string = '';
    private loading: boolean = false;
    
    cancel() {
        this.close.emit(true);
    }

    enter() {
        this.auth.signInWithAPIKey(this.apiKey);
        
        window.location.href = '/';
        window.location.reload();
    }
}
