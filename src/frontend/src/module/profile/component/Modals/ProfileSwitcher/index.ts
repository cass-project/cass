import {Component, Output, EventEmitter} from "@angular/core";
import {Session} from "../../../../session/Session";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";

@Component({
    selector: 'cass-profile-switcher',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSwitcher
{
    @Output('close') closeEvent = new EventEmitter<boolean>();

    private status: LoadingManager = new LoadingManager();

    constructor(
        private session: Session,
        private rest: ProfileRESTService
    ) {
        if(! session.isSignedIn()) {
            this.close();
        }
    }

    hasProfile(index: number) {
        return this.session.getCurrentAccount().profiles.profiles[index] !== undefined;
    }

    getProfile(index: number) {
        if(this.hasProfile(index)) {
            return this.session.getCurrentAccount().profiles.profiles[index].entity.profile;
        }else{
            throw new Error(`Profile with index '${index}' is not available`)
        }
    }

    createNewProfile() {
        let status = this.status.addLoading();

        this.rest.createNewProfile().subscribe(
            response => {
                window.location.href = '/';
            },
            error => {
                status.is = false;
            }
        );
    }

    switchToProfile(profile: ProfileEntity) {
        let status = this.status.addLoading();

        this.rest.switchProfile(profile.id).subscribe(
            response => {
                window.location.href = '/';
            },
            error => {
                status.is = false;
            }
        )
    }

    close() {
       this.closeEvent.emit(true); 
    }

    canCreateMoreProfiles() {
        return this.session.getCurrentAccount().profiles.profiles.length < 4;
    }
}