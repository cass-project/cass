import {Component} from "@angular/core";

import {ProfileModals} from "./modals";
import {Session} from "../../../../session/Session";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
})

export class ProfileComponent
{
    constructor(
        private session: Session,
        private modals: ProfileModals
    ) {}

    isSetupRequired() {
        if(this.session.isSignedIn()) {
            let testProfileIsInitialized = ! this.session.getCurrentProfile().entity.profile.is_initialized;
            let testIsOpened = this.modals.setup.isOpened();

            return testProfileIsInitialized || testIsOpened;
        }else{
            return false;
        }
    }
}