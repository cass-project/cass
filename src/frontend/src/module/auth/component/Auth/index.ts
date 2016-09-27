import {Component, Renderer} from "@angular/core";
import {AuthModalsService} from "./modals";

@Component({
    selector: 'cass-auth',
    template: require('./template.jade'),
})

export class AuthComponent
{
    constructor(
        private modals: AuthModalsService,
        private renderer: Renderer
    ) {}

    ngOnInit() {
        this.enableSignInWithAPIKeyFeature();
    }

    private enableSignInWithAPIKeyFeature() {
        this.renderer.listenGlobal('document', 'keyup', (event:KeyboardEvent) => {
            if (event.shiftKey && event.altKey && event.keyCode === 77 /* M */) {
                if (this.modals.signInWithAPIKeyModal.isOpened()) {
                    this.modals.closeAllModals();
                } else {
                    this.modals.signInWithAPIKey();
                }
            }
        });
    }
}