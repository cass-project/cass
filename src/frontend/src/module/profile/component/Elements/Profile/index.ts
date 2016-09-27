import {Component} from "@angular/core";

import {ProfileModals} from "./modals";
import {Session} from "../../../../session/Session";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {Router} from "@angular/router";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
})

export class ProfileComponent
{
    constructor(
        private session: Session,
        private modals: ProfileModals,
        private router: Router
    ) {}

    ngOnInit() {
        if(this.isSetupRequired()) {
            this.modals.setup.open();
        }
    }

    goCollection(collection: CollectionEntity) {
        this.router.navigate(['/profile/current/collections', collection.sid]);
    }

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